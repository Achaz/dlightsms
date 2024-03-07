#!/usr/bin/perl

use strict;
use warnings;

# 18.11.2021 - this is the perl script to send out SMS for DLIGHT. It will take one argument i.e. a text file and then 
# split it and send out the SMS accordingly. 
# $nums['msisdn']."|".$senderid."|".$final_msg."|".$list_id."|".$userid."|".$job_id."\n"; parameters to be passed. 

our $sourcefile	= shift;
my $count1 		= 0;
my $count2 		= 0;
our $sendscript = "/tmp/sendfile.sh" . int(rand(100000));

our $number = "01002001111";

# test the parameters to be sent to the perl script to send out SMS. i.e. numbers, senderid and message 
# sendsms.pl log_id senderno sourcefile message. 


my($sec,$min,$hour,$mday,$mon,$year,$wday,$yday,$isdst)=localtime(time);
sub URLEncode {
	       my $theURL = $_[0];
	       $theURL =~ s/([\W])/"%" . uc(sprintf("%2.2x",ord($1)))/eg;
	       return $theURL;
	     }

sub trim {
	my $str = $_[0];
        $str =~ s/^\s+|\s+$//g; 
        return $str;
}


#$_ = $message;
#s/^\s//;
#$message = $_;

# if(-e $sendscript) {
#        system("rm -f $sendscript");
# }

open(NUMBERS_TO_READ, "<$sourcefile") || die("Can't open file : $!");
open(FILE_TO_BCAST, ">>$sendscript") || die("Can't open file : $!");

my $host;
my $uname;
my $passwd;
my $smsc;
my $dest;
my $thost;
my $dlrmask;
my $dlrurl;
my $port;
my $q_str; my $str_url; 

while(my $fi = <NUMBERS_TO_READ>) {
	#my @dl = "$fi";
 	#print $fi."\n"; 	
	my ($msisdn,$senderid,$message,$list_id,$userid,$job_id) = split('\|',$fi);	

	#print $msisdn."\n".$senderid."\n".$message."\n".$list_id."\n".$userid."\n".$job_id."\n";
	#exit;	
	$_ = $msisdn; 

	chomp;
	s/\s//g;
# paremeter are prefix/networ/host dependent
# 'lynx -dump "http://localhost:13015/cgi-bin/sendsms?username=tester4&password=foobar4&smsc=smsc4&from='.$dest.'&to='.$sender.'&text='.$msg;
     	#MTN 
	if (/^25677/ || /^25678/ || /^25639/ || /^25676/ ) 

        { 	$host = '44.206.66.66';
    		$uname = 'smsapi';
    		$passwd = 'smsapi123';
    		$smsc = "SMSC02";
    		$dest = "8177";
    		$dlrmask = "31";
		$port = "13013";

    	}

	#Airtel 
	if (/^25675/ || /^25670/ || /^25674/)

        {       $host = 'localhost';
                $uname = 'smsadmin';
                $passwd = 'smsadmin123';
                $smsc = "SMSC03";
                $dest = "DLIGHTCARES";
                $dlrmask = "31";
                $port = "13013";

        }
	

	my $range = 2000;
	my $lc_time = time();
	my $random_number = int(rand($range) * $lc_time);

	$message = URLEncode($message);

	$dlrurl = "https://dlightsms.qed.co.ug/dlr?";
    $q_str = "log_no=$random_number&message=$message&user_id=$userid&senderid=$dest&phonenum=%p&smscid=%i&ts_stamp=%t&dlrvalue=%d&smsid=%I";
    $str_url = URLEncode($q_str);

    $dlrurl = $dlrurl.$str_url;

   	my $dlr = $dlrurl;# URLEncode($dlrurl);
	#my $cmd = "lynx -dump 'http://$host:$port/cgi-bin/sendsms?username=$uname&password=$passwd&from=$dest&to=$_&text=$message&smsc=$smsc&coding=0&dlr-url=$dlr&dlr-mask=$dlrmask'&";
    my $cmd = "lynx -dump 'http://localhost:13013/cgi-bin/sendsms?coding=0&smsc=$smsc&to=$_&from=8177&text=$message&username=smsadmin&password=smsadmin123&dlr-mask=31&dlr-url=$dlr'";
	#resume from here....12.11.2021

	my  $x = `$cmd`;
	#print $cmd."\n";	

	if($count1 == 20) {
		$count1 = 0;
		print FILE_TO_BCAST "sleep 2\n";
	}

	if($count2 == 4000) {
		$count2 = 0;
       	print FILE_TO_BCAST "sleep 2\n";
    }

	$count1++;
	$count2++;
}

close(NUMBERS_TO_READ) || die "Can't close $sourcefile: $!";
