<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Recuperar contraseña — CodePath</title>
<style>
* { margin: 0; padding: 0; box-sizing: border-box; }
body {
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', 
                 sans-serif;
    background-color: #0A0F1E;
    color: #ffffff;
    padding: 40px 20px;
}
.container {
    max-width: 560px;
    margin: 0 auto;
}
.card {
    background: #111827;
    border: 1px solid #1F2937;
    border-radius: 16px;
    overflow: hidden;
}
.header {
    background: linear-gradient(135deg, #1d4ed8, #1e40af);
    padding: 32px;
    text-align: center;
}
.logo {
    font-size: 28px;
    font-weight: 900;
    color: #ffffff;
    letter-spacing: 3px;
    text-transform: uppercase;
    margin-bottom: 4px;
}
.logo-sub {
    font-size: 11px;
    color: #93c5fd;
    letter-spacing: 2px;
    text-transform: uppercase;
}
.body {
    padding: 36px 32px;
}
.title {
    font-size: 22px;
    font-weight: 700;
    color: #ffffff;
    margin-bottom: 12px;
}
.text {
    font-size: 15px;
    color: #9ca3af;
    line-height: 1.6;
    margin-bottom: 16px;
}
.btn-container {
    text-align: center;
    margin: 28px 0;
}
.btn {
    display: inline-block;
    background: linear-gradient(135deg, #2563eb, #1d4ed8);
    color: #ffffff !important;
    text-decoration: none;
    font-size: 16px;
    font-weight: 700;
    padding: 14px 36px;
    border-radius: 12px;
    letter-spacing: 0.5px;
}
.divider {
    height: 1px;
    background: #1F2937;
    margin: 24px 0;
}
.link-box {
    background: #1F2937;
    border-radius: 8px;
    padding: 12px 16px;
    margin-top: 16px;
}
.link-box p {
    font-size: 12px;
    color: #6b7280;
    margin-bottom: 6px;
}
.link-box a {
    font-size: 12px;
    color: #60a5fa;
    word-break: break-all;
}
.warning {
    background: #fef3c7;
    border-left: 4px solid #f59e0b;
    border-radius: 4px;
    padding: 12px 16px;
    margin-top: 20px;
}
.warning p {
    font-size: 13px;
    color: #92400e;
}
.footer {
    padding: 20px 32px;
    background: #0A0F1E;
    text-align: center;
    border-top: 1px solid #1F2937;
}
.footer p {
    font-size: 12px;
    color: #4b5563;
    line-height: 1.6;
}
</style>
</head>
<body>
<div class="container">
    <div class="card">
        <div class="header">
            <div class="logo">⚡ CodePath</div>
            <div class="logo-sub">Plataforma de Aprendizaje</div>
        </div>

        <div class="body">
            <h1 class="title">🔐 Recuperar contraseña</h1>
            <p class="text">
                Hola, recibimos una solicitud para restablecer 
                la contraseña de tu cuenta en CodePath.
            </p>
            <p class="text">
                Haz clic en el botón de abajo para crear 
                una nueva contraseña. Este enlace expirará 
                en <strong style="color:#ffffff;">60 minutos</strong>.
            </p>

            <div class="btn-container">
                <a href="{{ $resetUrl }}" class="btn">
                    Restablecer contraseña →
                </a>
            </div>

            <div class="divider"></div>

            <p class="text" style="font-size:13px;">
                Si el botón no funciona, copia y pega 
                este enlace en tu navegador:
            </p>
            <div class="link-box">
                <p>Enlace de recuperación:</p>
                <a href="{{ $resetUrl }}">{{ $resetUrl }}</a>
            </div>

            <div class="warning">
                <p>
                    ⚠️ Si no solicitaste restablecer tu contraseña, 
                    ignora este correo. Tu cuenta está segura.
                </p>
            </div>
        </div>

        <div class="footer">
            <p>
                Este correo fue enviado por CodePath.<br>
                © {{ date('Y') }} CodePath — Todos los derechos reservados.
            </p>
        </div>
    </div>
</div>
</body>
</html>
