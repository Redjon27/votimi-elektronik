
<!DOCTYPE html>
<html>
    <head>
<style>
.response_msg {
    margin-top:10px;
    font-size:13px;
    background: green;
    color:#ffffff;
    width:300px;
    padding:20px;
    display:none;
    }
    .form-style-5{
	max-width: 800px;
	padding: 10px 20px;
	background: #f4f7f8;
	margin: 20px auto;
	padding: 30px;
	background: #f4f7f8;
	border-radius: 8px;
	font-family: Georgia, "Times New Roman", Times, serif;
}
.form-style-5 fieldset{
	border: none;
}
.form-style-5 legend {
	font-size: 1.4em;
	margin-bottom: 1px;
}
.form-style-5 label {
	display: block;
}
.form-style-5 input[type="text"],
.form-style-5 input[type="date"],
.form-style-5 input[type="datetime"],
.form-style-5 input[type="email"],
.form-style-5 input[type="number"],
.form-style-5 input[type="search"],
.form-style-5 input[type="time"],
.form-style-5 input[type="url"],
.form-style-5 textarea,
.form-style-5 select {
	font-family: Georgia, "Times New Roman", Times, serif;
	background: rgba(255,255,255,.1);
	border: none;
	border-radius: 10px;
	font-size: 15px;
	padding: 5px;
	width: 100%;
	box-sizing: border-box; 
	-webkit-box-sizing: border-box;
	-moz-box-sizing: border-box; 
	background-color: #e8eeef;
	color:black;
	-webkit-box-shadow: 0 1px 0 rgba(0,0,0,0.03) inset;
	box-shadow: 0 1px 0 rgba(0,0,0,0.03) inset;
	margin-bottom: 3px;
}
.form-style-5 input[type="text"]:focus,
.form-style-5 input[type="date"]:focus,
.form-style-5 input[type="datetime"]:focus,
.form-style-5 input[type="email"]:focus,
.form-style-5 input[type="number"]:focus,
.form-style-5 input[type="search"]:focus,
.form-style-5 input[type="time"]:focus,
.form-style-5 input[type="url"]:focus,
.form-style-5 textarea:focus,
.form-style-5 select:focus{
	background: #d2d9dd;
}
.form-style-5 select{
	-webkit-appearance: menulist-button;
	height:35px;
}
.form-style-5 .number {
	background: #1abc9c;
	color: #fff;
	height: 30px;
	width: 100px;
	display: inline-block;
	font-size: 0.8em;
	margin-right: 4px;
	line-height: 30px;
	text-align: center;
	text-shadow: 0 1px 0 rgba(255,255,255,0.2);
	border-radius: 15px 15px 15px 0px;
}

.form-style-5 input[type="submit"],
.form-style-5 input[type="button"]
{
	position: relative;
	display: block;
	padding: 19px 39px 18px 39px;
	color: #FFF;
	margin: 0 auto;
	background: #1abc9c;
	font-size: 18px;
	text-align: center;
	font-style: normal;
	width: 50%;
	border: 1px solid #16a085;
	border-width: 1px 1px 3px;
	margin-bottom: 10px;
}
.form-style-5 input[type="submit"]:hover,
.form-style-5 input[type="button"]:hover
{
	background: #109177;
}
.upload_movies_form{
    width: auto;
    position:relative;
}
    ::placeholder{
        text-align: left;
    }
    
    .text-center{
        text-align: center;
    }
 
</style>
    
    </head>
    </br>
    </br>
    </br>
    </br>
<body style="background-image: url(img/1.png);">
    <div class="upload_movies_form">
        <div class="form-style-5">
                <h1 style="text-align: center">Ju lutemi plotësoni të dhënat</h1>
                <form name="contact-form" method="post" id="contact-form">
                    <fieldset>
                        <legend><span class="number">Emri: </span><span style="color: red">*</span></legend>
                        <input type="text" name="emri" placeholder="Emri" required>
                    
                        <legend><span class="number">Mbiemri: </span><span style="color: red">*</span></legend>
                        <input type="text" name="mbiemri" placeholder="Mbiemri" required>
                    
                    
                        <legend><span class="number">Email: </span><span style="color: red">*</span></legend>
                        <input type="email" name="email" placeholder="Email" required>
                    
                        <legend><span class="number">Telefon: </span><span style="color: red">*</span></legend>
                        <input type="text" name="telefon" placeholder="Telefon" required>
                    
                        <legend><span class="number">Mesazhi: </span><span style="color: red">*</span></legend>
                        <textarea name="subjekti" rows="3" cols="28" rows="5" placeholder="Mesazhi..."></textarea> 
                    
                    <input type="submit" name="submit" value="Dërgo" id="submit_form">
                        </fieldset>
                </form>
                <div class="response_msg"></div>
            <label><p class="text-center">&copy; 2022 <a href="index.php" style="color: black">Zgjedhjet Online - Kthehu Te Kryefaqja</a></p></label>
            </div>
        </div>
    
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    
<script>
    
$(document).ready(function(){
    $("#contact-form").on("submit",function(e){
        e.preventDefault();
        if($("#contact-form [name='your_name']").val() === '')
        {
            $("#contact-form [name='your_name']").css("border","1px solid red");
        }
        else if ($("#contact-form [name='your_email']").val() === '')
        {
            $("#contact-form [name='your_email']").css("border","1px solid red");
        }
        else
        {
            $("#loading-img").css("display","block");
            var sendData = $( this ).serialize();
            $.ajax({
                type: "POST",
                url: "get_response.php",
                data: sendData,
                success: function(data){
                    $("#loading-img").css("display","none");
                    $(".response_msg").text(data);
                    $(".response_msg").slideDown().fadeOut(3000);
                    $("#contact-form").find("input[type=text], input[type=email], textarea").val("");
                }
            });
        }
    });
    $("#contact-form input").blur(function(){
        var checkValue = $(this).val();
        if(checkValue != '')
        {
            $(this).css("border","1px solid #eeeeee");
        }
    });
});
</script>
</body>
</html>