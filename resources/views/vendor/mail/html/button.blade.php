@php
$colors = [
    'primary'   => ['bg' => '#4f46e5', 'hover' => '#4338ca', 'text' => '#ffffff'],
    'success'   => ['bg' => '#059669', 'hover' => '#047857', 'text' => '#ffffff'],
    'error'     => ['bg' => '#dc2626', 'hover' => '#b91c1c', 'text' => '#ffffff'],
];
$color = $colors[$color ?? 'primary'];
@endphp

<table width="100%" cellpadding="0" cellspacing="0" role="presentation" style="margin: 28px 0;">
  <tr>
    <td align="left">
      <!--[if mso]>
      <v:roundrect xmlns:v="urn:schemas-microsoft-com:vml"
        href="{{ $url }}"
        style="height:48px; v-text-anchor:middle; width:220px;"
        arcsize="25%"
        stroke="f"
        fillcolor="{{ $color['bg'] }}">
        <w:anchorlock/>
        <center style="color:#ffffff; font-family:sans-serif; font-size:14px; font-weight:700;">
          {{ $slot }}
        </center>
      </v:roundrect>
      <![endif]-->
      <!--[if !mso]><!-->
      <a href="{{ $url }}"
         target="_blank"
         style="
           display: inline-block;
           background-color: {{ $color['bg'] }};
           color: {{ $color['text'] }};
           font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
           font-size: 14px;
           font-weight: 700;
           letter-spacing: 0.1px;
           text-decoration: none;
           padding: 14px 32px;
           border-radius: 12px;
           line-height: 1;
           mso-padding-alt: 0px;
         ">
        {{ $slot }}
      </a>
      <!--<![endif]-->
    </td>
  </tr>
</table>