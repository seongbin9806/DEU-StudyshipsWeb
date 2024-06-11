<div id="SignInView">
    <p class="title">
        <img src="/assets/image/logo.png"/>
        Study Sips
    </p>
    
    <p class="guide">Sign in</p>
    
    <input type="text" id="mbId" class="loginInput" placeholder="Your ID" onkeyup="SignInView.EnterLogin(event)"/>
    <input type="password" id="mbPassword" class="loginInput" placeholder="Your PASSWORD" onkeyup="SignInView.EnterLogin(event)"/>
    
    <button class="loginBtn" onclick="SignInView.CallSignIn()">
        <span>SIGN IN</span>
        <i class="fas fa-arrow-right"></i>
    </button>
    
    <p class="signupGuide">OR</p>
    
    <a class="goSignView" href="/SignUp/SignUpView">
        Don't have an account?
        <span>Sign up</span>
    </a>
</div>
    
<script>
    const SignInView = {
        EnterLogin: function(e){
            if(e.key === "Enter") {
                this.CallSignIn();
            }
        },
        CallSignIn: async function(){
            let $mbId = $('#mbId'),
                $mbPassword = $('#mbPassword');
            
            if(!$mbId.val()){
                util.showAlert("아이디를 입력해주세요.", () => $mbId.focus());
                return;
            }else if(!$mbPassword.val()){
                util.showAlert("비밀번호를 입력해주세요.", () => $mbPassword.focus());
                return;
            }
            
            const CallSignInRes = await util.postJson('/SignIn/CallSignIn', {
                mbId : $mbId.val(),
                mbPassword : $mbPassword.val()
            });
            
            if(!CallSignInRes.result){
                util.showAlert(CallSignInRes.msg);
                return;
            }
            
            /* 관리자 일 경우 */
            if($mbId.val() == 'deu-admin'){
                location.replace('/AdmSeatInsert/SeatManagement');
            }else{
                location.replace('/');
            }
        }
    };
</script>