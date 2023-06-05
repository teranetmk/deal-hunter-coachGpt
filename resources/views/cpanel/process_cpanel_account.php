<?php
set_time_limit(0);
ini_set('upload_max_filesize', '500M');
ini_set('post_max_size', '500M');
ini_set('memory_limit', '-1');

function addToList($domain, $username, $password): void
{
    global $conn;
    $check = mysqli_query($conn, "SELECT host_id from sds_host where server_type ='0' and host_name ='$domain'");
    if (mysqli_num_rows($check) == 0) {
        $conn_id = ftp_connect($domain);
        if ($conn_id) {
            if (@ftp_login($conn_id, $username, $password)) {
                mysqli_query($conn, "INSERT into sds_host (host_name,host_user,host_pass,login_id,create_ts,modify_ts,created_by,modified_by,server_type) VALUES('$domain',' $username','$password',88,'" . date("Y/m/d") . "','" . date("Y/m/d") . "',1,1,0)");
            }
        }
    }
}

include "xmlapi.php";
$obj = new stdClass();
$obj->whmdomain = $_POST['whmdomain'];
$server = $_POST['whmdomain'];
$auth_user = 'root';
$auth_pass = $_POST['rootpass'];
$domain = $_POST['cpaneldomainname'];

$obj->cpaneldomain = $_POST['cpaneldomainname'];


// WHM
$json_client = new xmlapi('hasb.com'); //whm.com || WHM IP
$json_client->set_output('json');
$json_client->set_port(2087);
$json_client->set_debug(1);
$json_client->password_auth('WHM USER', 'WHM PASS');




error_reporting(0);
$serverip = $server;

$cpanel_user = strtolower($_POST['cpanelusername']);
$cpanel_pass = $_POST['cpanelpassword'];
$args1 = array(
    'username' => $cpanel_user,
    'password' => $cpanel_pass,
    'domain' => $domain,
    'contactemail' => "",
    'pkgname' => "default"
);
$data = $json_client->createacct($args1);





try {
    $data = json_decode($data, true);
    if (isset($data['result'][0]['status']) && $data['result'][0]['status'] == 1) {
        $obj->status = "Success";
        $data['resultstatus'] = '1';
        addToList($domain, $cpanel_user, $cpanel_pass);
    } else {
        if (isset($data['result'][0]['statusmsg'])) {
            $obj->status = 'Error : ' . $domain . ' - ' . $data['result'][0]['statusmsg'];
        } else {
            $obj->status = 'Error : ' . $domain . ' - ' . $data['error'];
        }
        $data['resultstatus'] = '0';
    }
} catch (Exception $ex) {
    $obj->status = 'Error : ' . $domain;
    $data['resultstatus'] = '0';
}

$obj->cpanelusername = $cpanel_user;

$json_cpanel = new xmlapi($domain);
$json_cpanel->set_output('array');
$json_cpanel->set_port(2083);
$json_cpanel->password_auth($cpanel_user, $cpanel_pass);

if (isset($_POST['email_prefix']) && $_POST['email_prefix'] != '') {
    $email = (explode(",", $_POST['email_prefix']));
    $pass = (explode(",", $_POST['email_password']));
    $val = 0;
    try {
        foreach ($email as $si) {
            $obj->email = $email[$val];
            $obj->emailuser = $cpanel_user;
            $args = array(
                'domain' => $domain,
                'email' => $email[$val],
                'password' => $pass[$val],
                'quota' => '0'
            );
            $result = $json_cpanel->api2_query($cpanel_user, "Email", "addpop", $args);
            $val = $val + 1;
            if (isset($result['error']) && $result['error'] != '') {
                $obj->email_created = "0";
                $obj->email_status = "Email creation failed! Error: " . $result['error'];
                $error = 1;
            } else {
                $obj->email_created = "1";
                $obj->email_status = "Email Created Successfully on " . $domain . "";
            }
        }
    } catch (Exception $ex) {
        $obj->email_created = "0";
        $obj->email_status = "Email creation failed! Error:'" . $domain . "' Not Ready";
        $error = 1;
    }
}
if (isset($_POST['fwemailpr1']) && $_POST['fwemailpr1'] != '' && isset($_POST['fwemailto1']) && $_POST['fwemailto1'] != '') {
    $email = $_POST['email_prefix'];
    $emailpr = $_POST['fwemailpr1'];
    $emailto = $_POST['fwemailto1'];
    $fcreated = "forward1_created";
    $fstatus = "forward1_status";
    try {
        $call_f = array("domain" => $domain, "email" => $emailpr . '@' . $domain, "fwdopt" => "fwd", "fwdemail" => $emailto);
        $result = $json_cpanel->api2_query($cpanel_user, "Email", "addforward", $call_f);
        if (isset($result['error']) && $result['error'] != '') {
            $obj->$fcreated = "0";
            $obj->$fstatus = "Email Forwarding failed! for '" . $emailpr . '@' . $domain . "' to '" . $emailto . "'.Error: " . $result['error'] . "";
            $error = 1;
        } else {
            $obj->$fcreated = "1";
            $obj->$fstatus = "Email Forwarding created Successfully for forwarder  '" . $emailpr . '@' . $domain . "' to '" . $emailto . "'";
        }
    } catch (Exception $ex) {
        $obj->forward1_created = "0";
        $obj->forward1_status = "Email creation failed! Error:'" . $domain . "' Not Ready";
    }
} else {
    $obj->forward1_created = "0";
    $obj->forward1_status = "Prefix and Email Id both are mendatory to create forward Email.";
}

if (isset($_POST['fwemailpr2']) && $_POST['fwemailpr2'] != '' && isset($_POST['fwemailto2']) && $_POST['fwemailto2'] != '') {
    $email = $_POST['email_prefix'];
    $emailpr = $_POST['fwemailpr2'];
    $emailto = $_POST['fwemailto2'];
    $fcreated = "forward2_created";
    $fstatus = "forward2_status";

    try {
        $call_f = array("domain" => $domain, "email" => $emailpr . '@' . $domain, "fwdopt" => "fwd", "fwdemail" => $emailto);
        $result = $json_cpanel->api2_query($cpanel_user, "Email", "addforward", $call_f);
        if (isset($result['error']) && $result['error'] != '') {
            $obj->$fcreated = "0";
            $obj->$fstatus = "Email Forwarding failed! for '" . $emailpr . '@' . $domain . "' to '" . $emailto . "'.Error: " . $result['error'] . "";
            $error = 1;
        } else {
            $obj->$fcreated = "1";
            $obj->$fstatus = "Email Forwarding created Successfully for forwarder  '" . $emailpr . '@' . $domain . "' to '" . $emailto . "'";
        }

    } catch (Exception $ex) {
        $obj->forward2_created = "0";
        $obj->forward2_status = "Email creation failed! Error:'" . $domain . "' Not Ready";
    }
} else {
    $obj->forward2_created = "0";
    $obj->forward2_status = "Prefix and Email Id both are mendatory to create forward Email.";
}

if (isset($_POST['fwemailpr3']) && $_POST['fwemailpr3'] != '' && isset($_POST['fwemailto3']) && $_POST['fwemailto3'] != '') {
    $email = $_POST['email_prefix'];
    $emailpr = $_POST['fwemailpr3'];
    $emailto = $_POST['fwemailto3'];
    $fcreated = "forward3_created";
    $fstatus = "forward3_status";
    try {
        $call_f = array("domain" => $domain, "email" => $emailpr . '@' . $domain, "fwdopt" => "fwd", "fwdemail" => $emailto);
        $result = $json_cpanel->api2_query($cpanel_user, "Email", "addforward", $call_f);
        if (isset($result['error']) && $result['error'] != '') {
            $obj->$fcreated = "0";
            $obj->$fstatus = "Email Forwarding failed! for '" . $emailpr . '@' . $domain . "' to '" . $emailto . "'.Error: " . $result['error'] . "";
            $error = 1;
        } else {
            $obj->$fcreated = "1";
            $obj->$fstatus = "Email Forwarding created Successfully for forwarder  '" . $emailpr . '@' . $domain . "' to '" . $emailto . "'";
        }
    } catch (Exception $ex) {
        $obj->forward3_created = "0";
        $obj->forward3_status = "Email creation failed! Error:'" . $domain . "' Not Ready";
    }

} else {
    $obj->forward3_created = "0";
    $obj->forward3_status = "Prefix and Email Id both are mendatory to create forward Email.";
}

if (isset($_POST['fwemailpr4']) && $_POST['fwemailpr4'] != '' && isset($_POST['fwemailto4']) && $_POST['fwemailto4'] != '') {
    $email = $_POST['email_prefix'];
    $emailpr = $_POST['fwemailpr4'];
    $emailto = $_POST['fwemailto4'];
    $fcreated = "forward4_created";
    $fstatus = "forward4_status";
    try {
        $call_f = array("domain" => $domain, "email" => $emailpr . '@' . $domain, "fwdopt" => "fwd", "fwdemail" => $emailto);
        $result = $json_cpanel->api2_query($cpanel_user, "Email", "addforward", $call_f);
        if (isset($result['error']) && $result['error'] != '') {
            $obj->$fcreated = "0";
            $obj->$fstatus = "Email Forwarding failed! for '" . $emailpr . '@' . $domain . "' to '" . $emailto . "'.Error: " . $result['error'] . "";
            $error = 1;
        } else {
            $obj->$fcreated = "1";
            $obj->$fstatus = "Email Forwarding created Successfully for forwarder  '" . $emailpr . '@' . $domain . "' to '" . $emailto . "'";
        }
    } catch (Exception $ex) {
        $obj->forward4_created = "0";
        $obj->forward4_status = "Email creation failed! Error:'" . $domain . "' Not Ready";
    }
} else {
    $obj->forward4_created = "0";
    $obj->forward4_status = "Prefix and Email Id both are mendatory to create forward Email.";
}

if (isset($_POST['fwemailpr5']) && $_POST['fwemailpr5'] != '' && isset($_POST['fwemailto5']) && $_POST['fwemailto5'] != '') {
    $email = $_POST['email_prefix'];
    $emailpr = $_POST['fwemailpr5'];
    $emailto = $_POST['fwemailto5'];
    $fcreated = "forward5_created";
    $fstatus = "forward5_status";
    try {
        $call_f = array("domain" => $domain, "email" => $emailpr . '@' . $domain, "fwdopt" => "fwd", "fwdemail" => $emailto);
        $result = $json_cpanel->api2_query($cpanel_user, "Email", "addforward", $call_f);
        if (isset($result['error']) && $result['error'] != '') {
            $obj->$fcreated = "0";
            $obj->$fstatus = "Email Forwarding failed! for '" . $emailpr . '@' . $domain . "' to '" . $emailto . "'.Error: " . $result['error'] . "";
            $error = 1;
        } else {
            $obj->$fcreated = "1";
            $obj->$fstatus = "Email Forwarding created Successfully for forwarder  '" . $emailpr . '@' . $domain . "' to '" . $emailto . "'";
        }
    } catch (Exception $ex) {
        $obj->forward4_created = "0";
        $obj->forward4_status = "Email creation failed! Error:'" . $domain . "' Not Ready";
    }

} else {
    $obj->forward5_created = "0";
    $obj->forward5_status = "Prefix and Email Id both are mendatory to create forward Email.";
}
$jsobj = json_encode($obj);
session_start();
$_SESSION[$_POST['cpanelusername']] = $jsobj;
echo $_POST['cpanelusername'] . '&result=' . $data['resultstatus'];