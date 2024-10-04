<?php
defined('BASEPATH') or exit('No direct script access allowed');
function get_email_template_by_code($template_code, $fill_data)
{
    $emaildata = array();
    switch ($template_code) {
        case 'WELCOME_MAIL':
            $emaildata['template'] = 'Dear {student_name},
            <br /><br />
            Thank you for registering on the <strong>One Australia Group\'s PTE Portal</strong>. 
            <br /><br />
            We just wanted to say welcome.
            <br /><br />
            <b>Upsell 1 Extra Mock Test and find your coupon in Applykart</b>
            <br /><br />
            Please contact us if you need any help.
            <br /><br />
            Click here to login: <a href="{base_url}">{base_url}</a>
            <br /><br />
            Kind Regards,<br />
            {email_signature}
            <br /><br />';
            $emaildata['subject'] = 'Welcome aboard';
            break;
        case 'FORGOT_PASSWORD':
            $emaildata['template'] = 'Dear student,
            <br /><br />
            A new passcode for your account has been generated.
            <br /><br />
            New Passcode: {new_passcode}
            <br /><br />
            You use this passcode to access your account again.
            <br /><br />
            If you did not request this password reset, please contact our support team immediately.
            <br /><br />
            Thank you.
            <br /><br />
            Kind Regards, <br />
            {email_signature}
            <br /><br />';
            $emaildata['subject'] = 'Password Reset - New Passcode';
            break;
        case 'PACKAGE_PURCHASE_SUCCESS':
            $emaildata['template'] = 'Dear {student_name},
            <br /><br />
            We are delighted to inform you that your purchase of the {package_name}, has been successfully processed.
            <br /><br />
            Here are the details of your purchased package:
            <br /><br />
            Package Name: {package_name}<br />
            Package Duration: {package_duration}
            <br /><br />
            Total Cost: ${cost}
            <br /><br />
            Start Date: {start_date}<br />
            Expires On: {expiry_date}
            <br /><br />
            If you have any questions or require assistance with anything related to your package or its features, please do not hesitate to reach out to our dedicated customer support team.
            <br /><br />
            Thank you.
            <br /><br />
            Warm regards,<br />
            {email_signature}
            <br /><br />';
            $emaildata['subject'] = 'Your {package_name} Purchase Confirmation';
            break;
        case 'ACCOUNT_CREATION_MAIL':
            $emaildata['template'] = 'Dear {student_name},
            <br /><br />
            We are pleased to inform you that an account has been created for you in our system, granting you access to all the resources and services offered by One Australia Group. Welcome aboard!
            <br /><br />
            Below are your account credentials:
            <br /><br />
            Username: {username}<br />
            Temporary Password: {passcode}
            <br /><br />
            To get started, visit our website at <a href="{base_url}">{base_url}</a>.
            <br /><br />
            For security reasons, we recommend changing your password as soon as you log in for the first time. If you ever forget your password, you can use the "Forgot Password" option on the login page to reset it.
            <br /><br />
            If you encounter any issues during the login process or need assistance with any aspect of your account, please feel free to reach out to our support team. We are here to help.
            <br /><br />
            We\'re excited to have you as a part of the One Australia Group community and look forward to supporting your academic journey. Best wishes for your studies!
            <br /><br />
            Kind Regards,<br />
            {email_signature}';
            $emaildata['subject'] = 'Welcome to One Australia Group - Your User Account Details';
            break;
        case 'APPLYKART_REMINDER_CRON':
            $emaildata['template'] = 'Dear {student_name},
            <br /><br />
            We hope you\'re doing well!
            <br /><br />
            As a valued member of our community, we\'re excited to offer you an exclusive opportunity to enhance your preparation with a free mock test.
            <br /><br />
            To redeem your free mock test, simply follow these easy steps:
            <ol type="1">
                <li>Download the ApplyKart App from <a href="https://play.google.com/store/apps/details?id=com.applykart">Playstore</a> or <a href="https://apps.apple.com/in/app/applykart/id1638867413">Appstore</a>.</li>
                <li>Login with the same credentials of mockmaster on Applykart</li>
                <li>From the Academy section, get your code and login to <a href="{base_url}">mockmaster.ai</a></li>
            </ol>
            <br />
            This mock test is designed to give you a comprehensive understanding of the exam format and provide you with valuable insights to improve your performance.
            <br /><br />
            Don\'t miss out on this opportunity to give your preparation a significant boost. Download the ApplyKart app now and get started with your free mock test!
            <br /><br />
            If you have any questions or need assistance, please feel free to reach out to our support team.
            <br /><br />
            Kind Regards,<br />
            {email_signature}';
            $emaildata['subject'] = 'Redeem Your Free Mock Test on ApplyKart Now!';
            break;
    }

    foreach ($fill_data as $key => $value) {
        $pattern = '/{' . $key . '}/';
        $emaildata['template'] = preg_replace($pattern, $value, $emaildata['template']);
    }
    foreach ($fill_data as $key => $value) {
        $pattern = '/{' . $key . '}/';
        $emaildata['subject'] = preg_replace($pattern, $value, $emaildata['subject']);
    }

    return $emaildata;
}

function send_welcome_mail($receiver, $email_data)
{
    $CI = &get_instance();
    $CI->load->model('Iifl_info');

    $template = get_email_template_by_code('WELCOME_MAIL', $email_data);

    $CI->Iifl_info->sendmail($template['subject'], $receiver, $template['template']);

    return true;
}

function send_forgot_password_mail($receiver, $email_data)
{
    $CI = &get_instance();
    $CI->load->model('Iifl_info');

    $template = get_email_template_by_code('FORGOT_PASSWORD', $email_data);

    $CI->Iifl_info->sendmail($template['subject'], $receiver, $template['template']);

    return true;
}

function send_package_purchase_success_mail($receiver, $email_data)
{
    $CI = &get_instance();
    $CI->load->model('Iifl_info');

    $template = get_email_template_by_code('PACKAGE_PURCHASE_SUCCESS', $email_data);

    $CI->Iifl_info->sendmail($template['subject'], $receiver, $template['template']);

    return true;
}

function send_account_creation_mail($receiver, $email_data)
{
    $CI = &get_instance();
    $CI->load->model('Iifl_info');

    $template = get_email_template_by_code('ACCOUNT_CREATION_MAIL', $email_data);

    $CI->Iifl_info->sendmail($template['subject'], $receiver, $template['template']);

    return true;
}

function send_applykart_reminder_cron_mail($receiver, $email_data)
{
    $CI = &get_instance();
    $CI->load->model('Iifl_info');

    $template = get_email_template_by_code('APPLYKART_REMINDER_CRON', $email_data);

    $CI->Iifl_info->sendmail($template['subject'], $receiver, $template['template']);

    return true;
}