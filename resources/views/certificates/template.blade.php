<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<style>
@page {
    margin: 0;
    size: 297mm 210mm;
}

* { margin: 0; padding: 0; box-sizing: border-box; }

html, body {
    width: 297mm;
    height: 210mm;
    margin: 0;
    padding: 0;
    background-color: #0A0F1E;
    font-family: 'DejaVu Sans', sans-serif;
}

/* Main container table to force perfect centering */
.wrapper {
    width: 297mm;
    height: 210mm;
    border-collapse: collapse;
    background-color: #0A0F1E;
}

.content-cell {
    vertical-align: middle;
    text-align: center;
    padding-top: 10mm;
}

.cert-frame {
    width: 270mm;
    height: 185mm;
    margin: 0 auto;
    border: 2px solid #4F8EF7;
    border-radius: 8px;
    position: relative;
    background-color: #0A0F1E;
    overflow: hidden;
}

/* Corner accents - simplified for PDF rendering */
.corner {
    position: absolute;
    width: 24px;
    height: 24px;
    border-color: #39FF8A;
    border-style: solid;
}
.tl { top: 10px; left: 10px; border-width: 3px 0 0 3px; }
.tr { top: 10px; right: 10px; border-width: 3px 3px 0 0; }
.bl { bottom: 10px; left: 10px; border-width: 0 0 3px 3px; }
.br { bottom: 10px; right: 10px; border-width: 0 3px 3px 0; }

.inner-content {
    padding-top: 40px;
    color: #ffffff;
}

.brand {
    font-size: 32pt;
    font-weight: 900;
    color: #4F8EF7;
    letter-spacing: 12px;
    text-transform: uppercase;
    margin-bottom: 8px;
}

.label {
    font-size: 10pt;
    color: #39FF8A;
    letter-spacing: 6px;
    text-transform: uppercase;
    margin-bottom: 20px;
}

.divider {
    width: 80px;
    height: 2px;
    background: #4F8EF7;
    margin: 0 auto 25px auto;
    opacity: 0.6;
}

.certifies {
    font-size: 10pt;
    color: #94A3B8;
    letter-spacing: 4px;
    text-transform: uppercase;
    margin-bottom: 12px;
}

.name {
    font-size: 44pt;
    font-weight: 900;
    color: #ffffff;
    margin-bottom: 12px;
    line-height: 1.1;
}

.por {
    font-size: 12pt;
    color: #94A3B8;
    margin-bottom: 10px;
}

.course {
    font-size: 26pt;
    font-weight: 700;
    color: #4F8EF7;
    margin-bottom: 35px;
}

/* Stats table */
.stats {
    width: 450pt;
    margin: 0 auto 35px auto;
}
.stats-table {
    width: 100%;
    border-collapse: collapse;
}
.stats-td {
    width: 32%;
    text-align: center;
}
.stats-val {
    font-size: 24pt;
    font-weight: 900;
    color: #39FF8A;
}
.stats-lbl {
    font-size: 8pt;
    color: #64748B;
    letter-spacing: 2px;
    text-transform: uppercase;
}
.stats-sep {
    width: 1px;
    background: #334155;
    height: 40px;
}

/* Footer table */
.footer {
    width: 600pt;
    margin: 0 auto;
}
.footer-table {
    width: 100%;
}
.f-td {
    width: 33%;
    text-align: center;
    vertical-align: bottom;
}
.f-line {
    width: 120px;
    height: 1px;
    background: #334155;
    margin: 0 auto 10px auto;
}
.f-name {
    font-size: 10pt;
    font-weight: 700;
    color: #94A3B8;
}
.f-lbl {
    font-size: 8pt;
    color: #475569;
    letter-spacing: 1px;
    text-transform: uppercase;
}

.wm {
    position: absolute;
    bottom: 25px;
    width: 100%;
    text-align: center;
    font-size: 8pt;
    color: #1E3A5F;
    letter-spacing: 2px;
}
</style>
</head>
<body>
    <table class="wrapper">
        <tr>
            <td class="content-cell">
                <div class="cert-frame">
                    <div class="corner tl"></div>
                    <div class="corner tr"></div>
                    <div class="corner bl"></div>
                    <div class="corner br"></div>

                    <div class="inner-content">
                        <div class="brand">&#9889; INITCODE</div>
                        <div class="label">Certificado de Finalización</div>
                        <div class="divider"></div>
                        
                        <div class="certifies">Este certificado se otorga a</div>
                        <div class="name">{{ $user->name }}</div>
                        <div class="por">por completar exitosamente el curso</div>
                        <div class="course">{{ $course->title }}</div>

                        <div class="stats">
                            <table class="stats-table">
                                <tr>
                                    <td class="stats-td">
                                        <div class="stats-val">{{ $totalLessons }}</div>
                                        <div class="stats-lbl">Lecciones</div>
                                    </td>
                                    <td style="width:1px;"><div class="stats-sep"></div></td>
                                    <td class="stats-td">
                                        <div class="stats-val">{{ $totalXP }} XP</div>
                                        <div class="stats-lbl">Puntos ganados</div>
                                    </td>
                                    <td style="width:1px;"><div class="stats-sep"></div></td>
                                    <td class="stats-td">
                                        <div class="stats-val">100%</div>
                                        <div class="stats-lbl">Completado</div>
                                    </td>
                                </tr>
                            </table>
                        </div>

                        <div class="footer">
                            <table class="footer-table">
                                <tr>
                                    <td class="f-td">
                                        <div class="f-line"></div>
                                        <div class="f-name">InitCode Platform</div>
                                        <div class="f-lbl">Plataforma</div>
                                    </td>
                                    <td class="f-td">
                                        <div class="f-line"></div>
                                        <div class="f-name">{{ \Carbon\Carbon::parse($completionDate)->format('d/m/Y') }}</div>
                                        <div class="f-lbl">Fecha</div>
                                    </td>
                                    <td class="f-td">
                                        <div class="f-line"></div>
                                        <div class="f-name">{{ $user->level?->name ?? 'Estudiante' }}</div>
                                        <div class="f-lbl">Nivel</div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <div class="wm">
                        initcode.app &nbsp;•&nbsp; 
                        ID: CP-{{ strtoupper(substr(md5($user->id . $course->id), 0, 12)) }}
                    </div>
                </div>
            </td>
        </tr>
    </table>
</body>
</html>
