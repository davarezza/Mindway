(function (global) {
  'use strict';

  var KEY = 'mindway:v1';
  var TTL_DAYS = 30;
  var MAX_ASSESSMENTS = 5;

  function empty() {
    return { version: 1, assessments: [], journal: [] };
  }

  function read() {
    try {
      var raw = global.localStorage.getItem(KEY);
      var data = raw ? JSON.parse(raw) : null;
      if (data && data.version === 1 && Array.isArray(data.assessments)) {
        if (!Array.isArray(data.journal)) data.journal = [];
        return data;
      }
    } catch (e) {}
    return empty();
  }

  function write(data) {
    try {
      global.localStorage.setItem(KEY, JSON.stringify(data));
      return true;
    } catch (e) {
      return false;
    }
  }

  function prune(data) {
    var cutoff = Date.now() - TTL_DAYS * 86400000;
    var alive = function (iso) {
      var t = Date.parse(iso);
      return !isNaN(t) && t >= cutoff;
    };
    var a = data.assessments.filter(function (x) { return x && alive(x.createdAt); });
    var j = data.journal.filter(function (x) { return x && alive(x.entryDate); });
    a.sort(function (x, y) { return Date.parse(y.createdAt) - Date.parse(x.createdAt); });
    if (a.length > MAX_ASSESSMENTS) a = a.slice(0, MAX_ASSESSMENTS);
    var changed = a.length !== data.assessments.length || j.length !== data.journal.length;
    data.assessments = a;
    data.journal = j;
    return changed;
  }

  function load() {
    var data = read();
    if (prune(data)) write(data);
    return data;
  }

  function saveAssessment(record) {
    var data = load();
    var i = -1;
    data.assessments.forEach(function (x, idx) { if (x.id === record.id) i = idx; });
    if (i >= 0) data.assessments[i] = Object.assign({}, data.assessments[i], record);
    else data.assessments.push(record);
    prune(data);
    return write(data);
  }

  function listAssessments() {
    return load().assessments.slice();
  }

  function removeAssessment(id) {
    var data = load();
    var n = data.assessments.length;
    data.assessments = data.assessments.filter(function (x) { return x.id !== id; });
    if (data.assessments.length === n) return false;
    return write(data);
  }

  function clearAll() {
    try { global.localStorage.removeItem(KEY); return true; } catch (e) { return false; }
  }

  function getAssessment(id) {
    if (!id) return null;
    var found = null;
    load().assessments.forEach(function (x) { if (x.id === id) found = x; });
    return found;
  }

  function latestAssessment() {
    return load().assessments[0] || null;
  }

  function scorePatterns(signalSlugs, signalsMap, patternOrder) {
    var scores = {};
    var hasRedFlag = false;

    signalSlugs.forEach(function (slug) {
      var s = signalsMap[slug];
      if (!s) return;
      if (s.redFlag) { hasRedFlag = true; return; }
      if (!s.pattern) return;
      scores[s.pattern] = (scores[s.pattern] || 0) + (s.weight || 1);
    });

    var results = Object.keys(scores)
      .sort(function (a, b) {
        return scores[b] - scores[a] || (patternOrder[a] || 999) - (patternOrder[b] || 999);
      })
      .slice(0, 3)
      .map(function (slug, i) {
        return { patternSlug: slug, score: scores[slug], rank: i + 1 };
      });

    return { results: results, hasRedFlag: hasRedFlag };
  }

  function uuid() {
    if (global.crypto && typeof global.crypto.randomUUID === 'function') return global.crypto.randomUUID();
    return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function (c) {
      var r = (Math.random() * 16) | 0;
      return (c === 'x' ? r : (r & 3) | 8).toString(16);
    });
  }

  function encodeHash(obj) {
    return btoa(unescape(encodeURIComponent(JSON.stringify(obj))))
      .replace(/\+/g, '-').replace(/\//g, '_').replace(/=+$/, '');
  }

  function decodeHash(str) {
    try {
      var b = str.replace(/-/g, '+').replace(/_/g, '/');
      return JSON.parse(decodeURIComponent(escape(atob(b))));
    } catch (e) {
      return null;
    }
  }

  global.Mindway = {
    TTL_DAYS: TTL_DAYS,
    MAX_ASSESSMENTS: MAX_ASSESSMENTS,
    load: load,
    listAssessments: listAssessments,
    removeAssessment: removeAssessment,
    clearAll: clearAll,
    saveAssessment: saveAssessment,
    getAssessment: getAssessment,
    latestAssessment: latestAssessment,
    scorePatterns: scorePatterns,
    uuid: uuid,
    encodeHash: encodeHash,
    decodeHash: decodeHash
  };
})(window);
