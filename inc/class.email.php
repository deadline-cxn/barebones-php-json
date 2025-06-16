<?php
/**
 * Send an email message from server host
 *
 * @param {string} 'From' email address
 * @param {string} 'To' email address
 * @param {string} Message Subject
 * @param {string} Message Body
 *
 * @return {boolean}
 */

class Mail {

    var $from;
    var $to;
    var $subject;
    var $message;
    var $name;
    var $server_name;

    function __construct($newfrom="",$newto="",$newsubject="",$newmessage="") {
        $this->from=$newfrom;
        $this->to=$newto;
        $this->subject=$newsubject;
        $this->message=$newmessage;
    }

    /**
     * Set headers and send an email
     *
     * @param {void}
     * @return {boolean}
     */
    function Send() {
        if(!isset($name)) $name=$this->from;
        if(!isset($server_name)) $server_name="";
        if(isset($_SERVER['SERVER_NAME'])) if ($server_name == "" || $server_name == null) $server_name=$_SERVER['SERVER_NAME'];
        if ($server_name == "" || $server_name == null) $server_name="localhost";

        // Set date, message unique id and boundaries
        $tz = date('Z');
        $tzs = ($tz < 0) ? '-' : '+';
        $tz = abs($tz);
        $tz = ($tz/3600)*100 + ($tz%3600)/60;
        $sendDate = sprintf('%s %s%04d', date('D, j M Y H:i:s'), $tzs, $tz);
        $uniq_id = md5(uniqid(time()));
        $boundary[1] = 'b1_' . $uniq_id;
        $boundary[2] = 'b2_' . $uniq_id;

        // Wrap headers
        $header = '';
        $header .= 'Date: '.$sendDate."\n";
        $header .= 'Return-Path: '.$this->from."\n";
        $header .= 'From: '.$this->name.' <'.$this->from.">\n";
        $header .= 'Reply-to: '.$this->from."\n";
        $header .= sprintf('Message-ID: <%s@%s>%s', $uniq_id, $server_name, "\n");
        $header .= "X-Priority: 3\n";
        $header .= "X-Mailer: WEG [version 1.0]\n";
        $header .= "MIME-Version: 1.0\n";
        $header .= "Content-Transfer-Encoding: 7bit\n";
        $header .= sprintf("Content-Type: %s; charset=\"%s\"","text/html","UTF-8");
        $params  = sprintf('-oi -f %s', $this->from);

        // Set 'sendmail_from' address on php.ini while sending email, if safe mode is disabled
        if (strlen(ini_get('safe_mode')) < 1) {
            $old_from = ini_get('sendmail_from');
            ini_set('sendmail_from', $this->from);
            $result = mail($this->to, $this->subject, $this->message, $header, $params);
        }
        else
            $result = mail($this->to, $this->subject, $this->message, $header);

        // Restore 'sendmail_from' value on php.ini if necessary
        if (isset($old_from)) ini_set('sendmail_from', $old_from);

        if (!$result)
            return false;
        else
            return true;
    }
}

