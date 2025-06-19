<?php
		//////////////
		$MerchantID="GOVPOLCADT";
		$CustomerID="101";//sid
		$TxnAmount="1000";//amount
		$SecurityID="govpolcadt";
		$AdditionalInfo1="NA";//cid
		$AdditionalInfo2="Kunal Mahto";//name
		$AdditionalInfo3=4;//branch
		$AdditionalInfo4=1;//sem
		$AdditionalInfo5="NA";//roll
		$AdditionalInfo6=2020;//session
		//$Filler1="";
		//$BankID="";
		//$Filler2="";
		//$Filler3="";
		//$CurrencyType="";
		//$ItemCode="";
		//$TypeField1="";
		//$Filler4="";
		//$Filler5="";
		
		/////////////
		//$str = 'TESTME|UATTXN0001|NA|2|NA|NA|NA|INR|NA|R|NA|NA|NA|F|Andheri|Mumbai|02240920005|support@billdesk.com|NA|NA|NA|https://www.billdesk.com';
		$str = "".$MerchantID."|".$CustomerID."|NA|".$TxnAmount."|NA|NA|NA|INR|NA|R|".$SecurityID."|NA|NA|F|".$AdditionalInfo1."|".$AdditionalInfo2."|".$AdditionalInfo3."|".$AdditionalInfo4."|".$AdditionalInfo5."|".$AdditionalInfo6."|NA|NA";

		$checksum = hash_hmac('sha256',$str,'qxPCDqF1ppdIt890j4F2IVxZtwYVndTx', false); 
		$checksum = strtoupper($checksum);
		$final_msg="".$str."|".$checksum."";

?>
<!DOCTYPE html>
<html>
<head>

<script src="https://pgi.billdesk.com/payments-checkout-widget/src/app.bundle.js"></script>




 <center><a class="main-btn w3-button w3-round-large w3-blue" href="javascript:void(0)" onclick="validateForm()"
                    data-animation="fadeInUp" data-delay="1.5s" class="w3-button w3-blue">Proceed To Pay</a></center>
                                        <script src="https://pgi.billdesk.com/payments-checkout-widget1/src/app.bundle.js"></script>

 <form method="post" action="" name="form1" id="form1">


       <!-- <input type="text" name="childMsgString" value="merchantid|9876543210|NA|1|NA|NA|NA|INR|NA|R|security id|NA|NA|F|DSFDSF|sds@g.c|TDC 1ST YEAR|ARTS|NA|NA|NA|NA|checksumvalue">-->
        <input type="hidden" name="childMsgString" value="<?php echo $final_msg; ?>">

        
    </form>
<script type="text/javascript">
        function validateForm() {
        
                bdPayment.initialize({
                    msg: document.form1.childMsgString.value,options: {enableChildWindowPosting: true,
                        enablePaymentRetry: true,
			retry_attempt_count: 3},
                    callbackUrl:'http://www.gpadp.org.in/admin/gpaystatus.php'
                    
                    })
        }
                    </script><br><br>
<!-- <div class="w3-text-red w3-justify" id="demoFont"><strong>Note: If you are not going to pay Enrolment Fees this time then you should contact with College or You can use another Phone number to Enrol Newly and Pay Enrolment Fees.</strong></div> -->
</div>

</div>

<br>
</div>

</body>
</html>