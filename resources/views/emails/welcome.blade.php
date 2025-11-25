@php
    /** @var \App\Models\User $user */
    $user = $user ?? null;
    $ime = $user?->name ?? 'dragi korisniče';
@endphp

<!DOCTYPE html>
<html lang="sr">
<head>
    <meta charset="UTF-8">
    <title>Dobrodošli na Mali oglasi</title>
</head>
<body style="margin:0; padding:0; background-color:#f3f4f6; font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;">

<table width="100%" cellpadding="0" cellspacing="0" style="background-color:#f3f4f6; padding:24px 0;">
    <tr>
        <td align="center">
            <table width="600" cellpadding="0" cellspacing="0" style="background-color:#ffffff; border-radius:16px; overflow:hidden; box-shadow:0 10px 25px rgba(15,23,42,0.08);">
                {{-- HEADER --}}
                <tr>
                    <td style="padding:24px 32px; border-bottom:1px solid #e5e7eb; background:linear-gradient(135deg,#4f46e5,#6366f1);">
                        <table width="100%">
                            <tr>
                                <td align="left">
                                    {{-- MO logo krug --}}
                                    <div style="display:inline-flex; align-items:center;">
                                        <div style="height:48px; width:48px; border-radius:12px; background-color:#eef2ff; display:flex; align-items:center; justify-content:center; font-weight:800; font-size:20px; color:#4f46e5; margin-right:12px;">
                                            MO
                                        </div>
                                        <div style="color:#eef2ff;">
                                            <div style="font-size:20px; font-weight:700; line-height:1.2;">
                                                Mali oglasi
                                            </div>
                                            <div style="font-size:12px; opacity:0.9;">
                                                Vaše mesto za kupovinu i prodaju
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>

                {{-- BODY --}}
                <tr>
                    <td style="padding:32px;">
                        <h1 style="margin:0 0 12px 0; font-size:22px; color:#111827;">
                            Dobrodošli, {{ $ime }} 👋
                        </h1>

                        <p style="margin:0 0 16px 0; font-size:14px; color:#4b5563; line-height:1.6;">
                            Hvala vam što ste se registrovali na <strong>Mali oglasi</strong>.
                            Od sada možete da postavljate svoje oglase, kontaktirate druge korisnike i
                            lakše pronađete ono što tražite.
                        </p>

                        <p style="margin:0 0 20px 0; font-size:14px; color:#4b5563; line-height:1.6;">
                            Na svom profilu možete:
                        </p>

                        <ul style="margin:0 0 24px 20px; padding:0; font-size:14px; color:#374151; line-height:1.6;">
                            <li>Postavite nove oglase za prodaju stvari ili usluga</li>
                            <li>Pregledate i uređujete svoje postojeće oglase</li>
                            <li>Pratite kontakte i poruke zainteresovanih korisnika</li>
                            <li>Brže pronađete oglase preko kategorija i pretrage</li>
                        </ul>

                        {{-- Dugme --}}
                        <div style="text-align:center; margin-bottom:24px;">
                            <a href="{{ url('http://127.0.0.1/') }}"
                               style="display:inline-block; padding:10px 24px; background-color:#4f46e5; color:#ffffff; text-decoration:none; border-radius:999px; font-size:14px; font-weight:600;">
                                Otvori sajt Mali oglasi
                            </a>
                        </div>

                        <p style="margin:0 0 8px 0; font-size:13px; color:#6b7280; line-height:1.6;">
                            Ako imate bilo kakvo pitanje ili predlog, slobodno nam se javite – ovaj projekat
                            pravimo da bi bio što jednostavniji i korisniji za vas.
                        </p>

                        <p style="margin:0; font-size:13px; color:#6b7280;">
                            Srdačan pozdrav,<br>
                            <strong>Tim „Mali oglasi”</strong>
                        </p>
                    </td>
                </tr>

                {{-- FOOTER --}}
                <tr>
                    <td style="padding:16px 32px; border-top:1px solid #e5e7eb; background-color:#f9fafb; font-size:11px; color:#9ca3af; text-align:center;">
                        Ovu poruku ste dobili jer ste se registrovali na platformi Mali oglasi.<br>
                        Ako se niste vi registrovali, jednostavno ignorišite ovaj email.
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>

</body>
</html>
