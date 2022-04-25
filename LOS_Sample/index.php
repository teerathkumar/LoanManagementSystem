<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>LOS - Sample</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    </head>
    <body>
        <div class="container-xxl my-md-4 bd-layout">
            <main id="main">
                <section class="section">
                    <form method="get" class="bd-example" >
                        <div class="container">

                            <div class="form-group row">

                                <div class="col-sm">
                                    <label class="form-label">First Name</label>
                                    <input class="form-control" placeholder="First Name" type="text" name="fname" />        
                                </div>

                                <div class="col-sm">
                                    <label class="form-label">Middle Name</label>
                                    <input class="form-control" placeholder="Middle Name" type="text" name="mname" />        
                                </div>

                                <div class="col-sm">
                                    <label class="form-label">Last Name</label>
                                    <input class="form-control" placeholder="Last Name" type="text" name="lname" />        
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col">
                                    <label class="form-label">Gender</label>
                                    <input class="form-control" placeholder="Gender" type="text" name="gender" />        
                                </div>
                                <div class="col">
                                    <label class="form-label">Date of Birth</label>
                                    <input class="form-control" placeholder="Date of Birth" type="date" name="dob" />        
                                </div>
                                <div class="col">
                                    <label class="form-label">Caste</label>
                                    <input class="form-control" placeholder="Caste" type="text" name="caste" />        
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col">
                                    <label class="form-label">CNIC</label>
                                    <input class="form-control" placeholder="CNIC" type="text" name="cnic" />        
                                </div>
                                <div class="col">
                                    <label class="form-label">Mobile</label>
                                    <input class="form-control" placeholder="Mobile" type="text" name="mobile" />        
                                </div>
                                <div class="col">
                                    <label class="form-label">Address</label>
                                    <input class="form-control" placeholder="Address" type="text" name="address" />        
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col">
                                    <label class="form-label">Amount</label>
                                    <input class="form-control" placeholder="Amount" type="text" name="amount" />        
                                </div>
                                <div class="col">
                                    <label class="form-label">Tenure</label>
                                    <input class="form-control" placeholder="Tenure" type="text" name="loan_tenure" />        
                                </div>
                                <div class="col">
                                    <label class="form-label">Markup Rate</label>
                                    <input class="form-control" placeholder="Markup Rate" type="text" name="markup_rate" />        
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col">
                                    <label class="form-label">Frequency</label>
                                    <input class="form-control" placeholder="Frequency" type="text" name="loan_frequency" />        
                                </div>
                                <div class="col">
                                    <label class="form-label">Disbursement Date</label>
                                    <input class="form-control" placeholder="Disbursement Date" type="date" name="disb_date" />        
                                </div>
                                <div class="col">
                                    <label class="form-label">Repayment Start Date</label>
                                    <input class="form-control" placeholder="Repayment Start Date" type="date" name="rep_start_date" />        
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col">
                                    <label class="form-label">&nbsp;</label>
                                    <input class="form-control btn btn-success" type="button" value="Post to LMS" />  
                                </div>
                            </div>

                        </div>
                    </form>
                </section>
            </main>
        </div>
        <?php
        // put your code here
        ?>

        <script src="https://code.jquery.com/jquery-3.6.0.min.js" type="text/javascript" ></script>
        <script>
            $(document).ready(function () {
                $(".btn").click(function () {
                    var formData = $('form').serialize();
                    $.ajax({
                        type: "GET",
                        url: "LMSPost.php",
                        data: formData,
                        success: function (response) {
                            alert(response);
                            if (response == 1) {
                                //$("#err").html("Hi Tony");//updated
                            } else {
                                //$("#err").html("I dont know you.");//updated
                            }
                        },
                        error: function () {
                            alert('fail');
                        }
                    });
                });
            });

        </script>
    </body>
</html>
