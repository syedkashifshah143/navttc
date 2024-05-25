<?php
include('adminPanel/dbcon.php');

session_start();

// Sign-up Start
$uName = $uEmail = $uPwd = $ucPwd = "";
$unameerr = $uemailerr = $upwderr = $ucpwderr = "";
if(isset($_POST['signUp'])){
    $uName = $_POST['uname'];
    $uEmail = $_POST['uemail'];
    $uPwd = $_POST['upwd'];
    $ucPwd = $_POST['ucpwd'];
    if(empty($_POST['uname'])){
        $unameerr = "Please ente your Name";
    }
    if(empty($_POST['uemail'])){
        $uemailerr = "Please enter your Password";
    }
    else{
        $query = $pdo->prepare("select * from users where email=:uemail");
        $query->bindParam(':uemail',$uEmail);
        $query->execute();
        $user = $query->fetch(PDO::FETCH_ASSOC);
        IF($user){
            $uemailerr = "Email already exist";
        }
    }
    if(empty($_POST['upwd'])){
        $upwderr = "Please enter your password";
    }
    if(empty($_POST['ucpwd'])){
        $ucpwderr = "Please enter your confirm password";
    }else{
        if($uPwd !== $ucPwd){
            $ucpwderr = "Password does not match";
        }
    }
    if(empty($unameerr)&& empty($uemailerr) && empty($upwderr) && empty($ucpwderr) ){
        $hashpwd = sha1($uPwd);
        $query = $pdo->prepare("insert into users (name, email, password) values (:uname, :uemail, :upwd) ");
        $query->bindParam(':uname' , $uName);
        $query->bindParam(':uemail' , $uEmail);
        $query->bindParam(':upwd' , $hashpwd);
        $query->execute();
        echo "<script>alert('Registeration successful, Please sign-in');
        location.assign('login.php')</script>";
        $uName = $uEmail = $uPwd = $ucPwd = "";
    }


}
// Sign-up End 

// Login Start
$loginnameerr = $loginpwderr = "";
if(isset($_POST['login'])){
    $loginName = $_POST['loginname'];
    $loginPwd = $_POST['loginpwd'];
    if(empty($loginName)){
        $loginnameerr = "Please Enter Username";
    }
    if(empty($_POST['loginpwd'])){
        $loginpwderr = "Please enter password";
    }
    if($loginName !== "" && $loginPwd !== ""){
        $query = $pdo->query("select * from users ");
        $userdetails = $query->fetchAll(PDO::FETCH_ASSOC);
        foreach($userdetails as $emailpwd){
            // print_r($emailpwd) ;
            $dehashpwd = $emailpwd['password'];
            $hashloginpwd = sha1($loginPwd);
            if($emailpwd['email'] === $loginName && $dehashpwd === $hashloginpwd ){
               if($emailpwd['roleid'] == 1 ){
                $_SESSION['adminid'] = $emailpwd['id'];
                $_SESSION['adminemail'] = $emailpwd['email'];
                $_SESSION['adminname'] = $emailpwd['name'];
                echo "<script>location.assign('AdminPanel/index.php');
                </script>";
               } 
               else if($emailpwd['roleid'] == 2){
                $_SESSION['userid'] = $emailpwd['id'];
                $_SESSION['useremail'] = $emailpwd['email'];
                $_SESSION['username'] = $emailpwd['name'];
                echo "<script>location.assign('index.php')</script>";
                
               }
                
            } else{
                $loginnameerr = "Login user or password is invalid";
            }
        }
    }
}
// Login End

// Search Products Start
if(isset($_POST['search-product'])){
    $inpval = $_POST['search-product'];
    $searchPro = $pdo->prepare("select * from products where name like :proname");
    $inpval = "%$inpval%";
    $searchPro->bindParam(':proname', $inpval);
    $searchPro->execute();
    $allProducts = $searchPro->fetchAll(PDO::FETCH_ASSOC);
    foreach($allProducts as $proData){
    ?>
    <div class="col-sm-6 col-md-4 col-lg-3 p-b-35 isotope-item <?php echo $proData['catid']?>">
					<!-- Block2 -->
					<div class="block2">
						<div class="block2-pic hov-img0">
							<img height="250px" src="AdminPanel/img/<?php echo $proData['image']?>" alt="IMG-PRODUCT">

							<a href="#" class="block2-btn flex-c-m stext-103 cl2 size-102 bg0 bor2 hov-btn1 p-lr-15 trans-04 js-show-modal1">
								Quick View
							</a>
						</div>

						<div class="block2-txt flex-w flex-t p-t-14">
							<div class="block2-txt-child1 flex-col-l ">
								<a href="product-detail?pid=<?php echo $proData['id']?>" class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6">
									<?php echo $proData['name']?>
								</a>

								<span class="stext-105 cl3">
								<?php echo $proData['price']?>
								</span>
							</div>

							<div class="block2-txt-child2 flex-r p-t-3">
								<a href="#" class="btn-addwish-b2 dis-block pos-relative js-addwish-b2">
									<img class="icon-heart1 dis-block trans-04" src="images/icons/icon-heart-01.png" alt="ICON">
									<img class="icon-heart2 dis-block trans-04 ab-t-l" src="images/icons/icon-heart-02.png" alt="ICON">
								</a>
							</div>
						</div>
					</div>
	</div>
    <?php
    }
}

?>