<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mime\Part\HtmlPart;
use Symfony\Component\Mime\Part\TextPart;

class EmailController extends Controller
{
 public static function taskAssignTo_Notification($email, $link)
 {
  // dd(public_path("/") . 'assets/email_templates/styles.css');
  $style = file_get_contents(public_path("/") . 'assets/email_templates/styles.css');
  // dd($style);

  $htmlEmailContent = "
<!DOCTYPE html
 PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
<html xmlns='http://www.w3.org/1999/xhtml'>

<head>
 <meta name='viewport' content='width=device-width' />
 <meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
 <title>Email Message</title>
 <style> $style </style>
</head>

<body>
 <table class='body-wrap'>
  <tr>
   <td></td>
   <td class='container' width='600'>
    <div class='content'>
     <table class='main' width='100%' cellpadding='0' cellspacing='0'>
      <tr>
       <td class='content-wrap'>
        <table cellpadding='0' cellspacing='0'>
         <tr>
          <td>
           <div class='header img-responsive'>
            <h1>AHT</h1>
            <p>EMAIL MESSAGE FROM AHT</p>
           </div>
          </td>
         </tr>
         <tr>
          <td class='content-block' style='color: #000000'>
           <h3>Task Assign To You</h3>
          </td>
         </tr>
         <tr>
          <td class='content-block' style='color: #000000'>
           This is a notice to inform you that a mission has been assigned to you! Please consider detailed information
           about the task and ensure it completes it within the prescribed time. If you have any questions or have
           difficulty in the process, do not hesitate to contact the task person for assistance. We believe in your
           ability and hope you will complete the task excellently.
          </td>
         </tr>
         <tr>
          <td class='content-block' style='color: #000000'>
           Please click the link below to view the task!
          </td>
         </tr>
         <tr>
          <td class='content-block aligncenter'>
           <a href='$link' class='btn-primary' style='color: #ffffff'>View Task</a>
          </td>
         </tr>
        </table>
       </td>
      </tr>
     </table>
     <div class='footer'>
      <table width='100%'>
       <tr>
        <td class='aligncenter content-block'>
         More information: <a href='https://www.arrowhitech.com/'>@Company</a> on Website.
        </td>
       </tr>
      </table>
     </div>
    </div>
   </td>
   <td></td>
  </tr>
 </table>
</body>
</html>
    ";

  Mail::send([], [], function ($message) use ($email, $htmlEmailContent) {
   $message->to($email)
    ->subject('Task Notification')
    ->html($htmlEmailContent, 'text/html');
  });
 }
}