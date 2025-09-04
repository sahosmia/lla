@props(['btnText' => '', 'btnUrl' => ''])
<table width="100%" role="presentation" cellspacing="0" cellpadding="0" border="0">
    <tbody>
       <tr>
          <td style="font-size:0px;padding:0px;word-break:break-word" align="center">
             <div style="font-family:Helvetica,Arial,sans-serif; margin: 10px 0 10px;font-size:14px;line-height:18px;text-align:left;color:#4c4c4c;display: inline-block;">
                <a href="{{ $btnUrl }}" style="font-family:Helvetica,Arial,sans-serif;font-size:14px;line-height:18px;text-align:left;color:#fff; background-color: #295C51; display: block; border-radius: 10px; padding: 10px; text-decoration: none;">{{ $btnText }}</a>
             </div>
          </td>
       </tr>
    </tbody>
 </table>