(function (global) {
  'use strict';

  var PAGE_W = 210;
  var PAGE_H = 297;
  var M = 18;
  var W = PAGE_W - M * 2;
  var HEAD_H = 38;
  var LIMIT_Y = 276;
  var PAD = 6;

  var INDIGO = [30, 27, 75];
  var TEXT = [51, 65, 85];
  var MUTED = [120, 134, 156];
  var BORDER = [226, 232, 240];
  var EMERALD = [4, 120, 87];
  var MONTHS = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
  var OUTCOME = { selesai: 'Selesai', masih_berat: 'Masih berat', istirahat_dulu: 'Istirahat dulu' };

  function rgb(hex) {
    var m = /^#?([0-9a-f]{2})([0-9a-f]{2})([0-9a-f]{2})$/i.exec(hex || '');
    return m ? [parseInt(m[1], 16), parseInt(m[2], 16), parseInt(m[3], 16)] : [99, 102, 241];
  }

  function tint(c, a) {
    return c.map(function (v) { return Math.round(255 - (255 - v) * a); });
  }

  function clean(t) {
    return String(t == null ? '' : t)
      .replace(/[‘’]/g, "'")
      .replace(/[“”]/g, '"')
      .replace(/[–—]/g, '-')
      .replace(/ /g, ' ')
      .replace(/[^\x09\x0A\x0D\x20-\x7E¡-ÿ]/g, '');
  }

  function pad2(n) { return (n < 10 ? '0' : '') + n; }

  function fmtDate(iso) {
    var d = new Date(iso);
    if (isNaN(d)) return '';
    return d.getDate() + ' ' + MONTHS[d.getMonth()] + ' ' + d.getFullYear() + ', ' + pad2(d.getHours()) + ':' + pad2(d.getMinutes());
  }

  function fmtDay(d) {
    return d.getDate() + ' ' + MONTHS[d.getMonth()] + ' ' + d.getFullYear();
  }

  function fileName(now) {
    var d = now || new Date();
    return 'mindway-riwayat-' + d.getFullYear() + '-' + pad2(d.getMonth() + 1) + '-' + pad2(d.getDate()) + '.pdf';
  }

  function layoutCard(doc, rec, data) {
    var innerW = W - PAD * 2;
    var ops = [];
    var y = PAD + 4;

    ops.push({ t: 'text', x: PAD, y: y, s: fmtDate(rec.createdAt), font: 'bold', size: 11.5, color: INDIGO });
    y += 6;

    var results = (rec.results || []).filter(function (r) { return data.patterns[r.patternSlug]; });

    if (results.length) {
      doc.setFont('helvetica', 'bold');
      doc.setFontSize(9);
      var x = PAD;
      var rowH = 7;
      results.forEach(function (r) {
        var p = data.patterns[r.patternSlug];
        var label = clean(p.title);
        var w = doc.getTextWidth(label) + 10;
        if (x + w > PAD + innerW && x > PAD) { x = PAD; y += rowH + 2; }
        ops.push({ t: 'chip', x: x, y: y, w: w, h: rowH, s: label, color: rgb(p.color) });
        x += w + 3;
      });
      y += rowH + 5;

      var first = data.patterns[results[0].patternSlug];
      ops.push({ t: 'text', x: PAD, y: y, s: 'Yang bisa dilakukan sekarang', font: 'bold', size: 8.5, color: EMERALD });
      y += 4.8;
      doc.setFont('helvetica', 'normal');
      doc.setFontSize(10);
      doc.splitTextToSize(clean(first.nowAction), innerW).forEach(function (line) {
        ops.push({ t: 'text', x: PAD, y: y, s: line, font: 'normal', size: 10, color: TEXT });
        y += 4.8;
      });
      y += 2;
    } else {
      ops.push({ t: 'text', x: PAD, y: y + 3, s: 'Belum ada pola yang menonjol dari jawabanmu.', font: 'normal', size: 10, color: MUTED });
      y += 9;
    }

    var a = rec.action;
    var mode = a && data.modes[a.modeSlug];
    if (mode) {
      var plan = mode.plans[a.planSlug];
      var step = plan && plan.steps[a.chosenStep];
      ops.push({ t: 'line', x1: PAD, x2: PAD + innerW, y: y - 1, color: BORDER });
      y += 5;
      ops.push({ t: 'text', x: PAD, y: y, s: 'Langkah yang dipilih', font: 'bold', size: 8.5, color: MUTED });
      y += 5;
      ops.push({ t: 'text', x: PAD, y: y, s: clean(mode.title), font: 'bold', size: 10, color: rgb(mode.color) });
      var outcome = OUTCOME[a.outcome];
      if (outcome) {
        ops.push({ t: 'text', x: PAD + innerW, y: y, s: outcome, font: 'bold', size: 9, color: MUTED, align: 'right' });
      }
      y += 5;
      if (step) {
        doc.setFont('helvetica', 'normal');
        doc.setFontSize(10);
        doc.splitTextToSize(clean(step), innerW).forEach(function (line) {
          ops.push({ t: 'text', x: PAD, y: y, s: line, font: 'normal', size: 10, color: TEXT });
          y += 4.8;
        });
      }
    }

    return { ops: ops, h: y + PAD - 1 };
  }

  function drawCard(doc, card, y0) {
    doc.setDrawColor(BORDER[0], BORDER[1], BORDER[2]);
    doc.setFillColor(255, 255, 255);
    doc.setLineWidth(0.3);
    doc.roundedRect(M, y0, W, card.h, 3, 3, 'FD');

    card.ops.forEach(function (op) {
      if (op.t === 'text') {
        doc.setFont('helvetica', op.font);
        doc.setFontSize(op.size);
        doc.setTextColor(op.color[0], op.color[1], op.color[2]);
        doc.text(op.s, M + op.x, y0 + op.y, op.align ? { align: op.align } : undefined);
      } else if (op.t === 'chip') {
        var bg = tint(op.color, 0.16);
        doc.setFillColor(bg[0], bg[1], bg[2]);
        doc.roundedRect(M + op.x, y0 + op.y, op.w, op.h, op.h / 2, op.h / 2, 'F');
        doc.setFillColor(op.color[0], op.color[1], op.color[2]);
        doc.circle(M + op.x + 4, y0 + op.y + op.h / 2, 1.1, 'F');
        doc.setFont('helvetica', 'bold');
        doc.setFontSize(9);
        doc.setTextColor(30, 41, 59);
        doc.text(op.s, M + op.x + 7, y0 + op.y + op.h / 2 + 1.2);
      } else if (op.t === 'line') {
        doc.setDrawColor(op.color[0], op.color[1], op.color[2]);
        doc.line(M + op.x1, y0 + op.y, M + op.x2, y0 + op.y);
      }
    });
  }

  function build(jsPDF, assessments, data) {
    var doc = new jsPDF({ unit: 'mm', format: 'a4', compress: true });
    doc.setProperties({ title: 'Riwayat Mindway', subject: 'Riwayat asesmen', creator: 'Mindway' });

    doc.setFillColor(INDIGO[0], INDIGO[1], INDIGO[2]);
    doc.rect(0, 0, PAGE_W, HEAD_H, 'F');
    doc.setTextColor(255, 255, 255);
    doc.setFont('helvetica', 'bold');
    doc.setFontSize(22);
    doc.text('Mindway', M, 18);
    doc.setFont('helvetica', 'normal');
    doc.setFontSize(11);
    doc.setTextColor(199, 210, 254);
    doc.text('Riwayat asesmen', M, 26);
    doc.setFontSize(9);
    doc.text('Dibuat ' + fmtDay(new Date()), PAGE_W - M, 18, { align: 'right' });

    var y = HEAD_H + 10;
    doc.setFont('helvetica', 'normal');
    doc.setFontSize(10);
    doc.setTextColor(TEXT[0], TEXT[1], TEXT[2]);
    doc.splitTextToSize('Ringkasan hasil asesmen yang tersimpan di browser kamu. Ini gambaran dari apa yang kamu pilih, bukan diagnosis.', W).forEach(function (line) {
      doc.text(line, M, y);
      y += 5;
    });
    y += 5;

    assessments.forEach(function (rec) {
      var card = layoutCard(doc, rec, data);
      if (y + card.h > LIMIT_Y) {
        doc.addPage();
        y = M;
      }
      drawCard(doc, card, y);
      y += card.h + 6;
    });

    var note = doc.splitTextToSize('Kalau terasa berat, kamu boleh mencari dukungan dari orang yang kamu percaya atau layanan konseling di kampusmu. Kamu nggak harus melewatinya sendirian.', W - 12);
    var noteH = note.length * 4.8 + 10;
    if (y + noteH > LIMIT_Y) {
      doc.addPage();
      y = M;
    }
    doc.setFillColor(238, 242, 255);
    doc.roundedRect(M, y, W, noteH, 3, 3, 'F');
    doc.setFont('helvetica', 'normal');
    doc.setFontSize(9.5);
    doc.setTextColor(55, 48, 163);
    note.forEach(function (line, i) { doc.text(line, M + 6, y + 7 + i * 4.8); });

    var total = doc.getNumberOfPages();
    for (var p = 1; p <= total; p++) {
      doc.setPage(p);
      doc.setDrawColor(BORDER[0], BORDER[1], BORDER[2]);
      doc.setLineWidth(0.3);
      doc.line(M, PAGE_H - 16, PAGE_W - M, PAGE_H - 16);
      doc.setFont('helvetica', 'normal');
      doc.setFontSize(8);
      doc.setTextColor(MUTED[0], MUTED[1], MUTED[2]);
      doc.text('Mindway - dibuat di perangkatmu, tidak dikirim ke server', M, PAGE_H - 10);
      doc.text('Halaman ' + p + ' dari ' + total, PAGE_W - M, PAGE_H - 10, { align: 'right' });
    }
    return doc;
  }

  global.Mindway = global.Mindway || {};
  global.Mindway.buildPdf = build;
  global.Mindway.pdfFileName = fileName;
})(window);
