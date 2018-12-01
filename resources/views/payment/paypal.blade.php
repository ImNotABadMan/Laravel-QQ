<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title></title>
</head>
<body>
<form
    action="https://securepayments.sandbox.paypal.com/webapps/HostedSoleSolu
tionApp/webflow/sparta/hostedSoleSolutionProcess" method="post">
    <input type="hidden" name="cmd" value="_hosted-payment">
    <input type="hidden" name="subtotal" value="50">
    <input type="hidden" name="business" value="{{ $merchantID }}">
    <input type="hidden" name="paymentaction" value="sale">
    <input type="hidden" name="return"
           value="http://localhost/paypalCreditCard/ipn">
    <input type="submit" name="METHOD" value="Pay Now">
</form>
</body>
</html>
<pre>
[2018-12-01 07:53:10] local.INFO: array (
)
[2018-12-01 08:21:50] local.INFO: array (
    'transaction_subject' => NULL,
    'txn_type' => 'web_accept',
    'payment_date' => '00:18:29 Dec 01, 2018 PST',
    'last_name' => NULL,
    'receipt_id' => '1749-3982-3988-2832',
    'residence_country' => 'GB',
    'pending_reason' => 'multi_currency',
    'item_name' => NULL,
    'payment_gross' => '50.00',
    'mc_currency' => 'USD',
    'business' => 'test_nighslee@uk.com',
    'payment_type' => 'instant',
    'protection_eligibility' => 'Ineligible',
    'verify_sign' => 'ArgX1JoEl.LNTJ5nkTmgzkfLaDiVAVzj6teRjq2ncYFLAom.rCGmzKSw',
    'payer_status' => 'unverified',
    'test_ipn' => '1',
    'tax' => '0.00',
    'txn_id' => '783650404M242762E',
    'quantity' => '1',
    'receiver_email' => 'test_nighslee@uk.com',
    'first_name' => NULL,
    'payer_id' => 'BQZ38KN7U77ZW',
    'receiver_id' => 'L96AM84UCNEQU',
    'item_number' => NULL,
    'handling_amount' => '0.00',
    'payment_status' => 'Pending',
    'shipping' => '0.00',
    'mc_gross' => '50.00',
    'custom' => NULL,
    'charset' => 'windows-1252',
    'notify_version' => '3.9',
    'ipn_track_id' => '5f705238be5fe',
)
[2018-12-01 08:24:13] local.INFO: array (
    'redirect_to_merchant' => 'Bin 郑\'s Test Store',
    'tx' => '17P70054PN275430V',
    'CSCMATCH' => 'S',
    'AVSCODE' => 'Y',
)
[2018-12-01 08:24:37] local.INFO: array (
    'transaction_subject' => NULL,
    'txn_type' => 'web_accept',
    'payment_date' => '00:24:09 Dec 01, 2018 PST',
    'last_name' => NULL,
    'receipt_id' => '0478-0835-5407-1786',
    'residence_country' => 'GB',
    'pending_reason' => 'multi_currency',
    'item_name' => NULL,
    'payment_gross' => '50.00',
    'mc_currency' => 'USD',
    'business' => 'test_nighslee@uk.com',
    'payment_type' => 'instant',
    'protection_eligibility' => 'Ineligible',
    'verify_sign' => 'AOPtsZTsLdGaMT1K2tKhK4gdgZ1jADMDBwuqGwoJ5ECHLCnaz.iHgw8O',
    'payer_status' => 'unverified',
    'test_ipn' => '1',
    'tax' => '0.00',
    'txn_id' => '17P70054PN275430V',
    'quantity' => '1',
    'receiver_email' => 'test_nighslee@uk.com',
    'first_name' => NULL,
    'payer_id' => 'BQZ38KN7U77ZW',
    'receiver_id' => 'L96AM84UCNEQU',
    'item_number' => NULL,
    'handling_amount' => '0.00',
    'payment_status' => 'Pending',
    'shipping' => '0.00',
    'mc_gross' => '50.00',
    'custom' => NULL,
    'charset' => 'windows-1252',
    'notify_version' => '3.9',
    'ipn_track_id' => 'c1edbed88ec20',
)
</pre>
