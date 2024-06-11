<div id="SignUpView">    
    
    <p class="guide">Sign up</p>
    
    <p id="idErrMsg1" class="errMsg hide">아이디는 5자이상 입력해주세요.</p>
    <p id="idErrMsg2" class="errMsg hide">아이디 중복체크를 진행해주세요.</p>
    <div class="inputContainer">
        <input type="text" id="mbId" class="input" placeholder="Your ID" maxlength="15" onkeyup="SignUp.checkInputId()"/>
        <button id="checkSameIdBtn" class="checkSameIdBtn" onclick="SignUp.checkSameId()" data-checked="N">중복체크</button>        
    </div>
    
    <p id="pwdErrMsg" class="errMsg hide">비밀번호는 6자이상 입력해주세요.</p>
    <input type="password" id="mbPassword" maxlength="15" class="input" placeholder="Your Password" onkeyup="SignUp.checkInputPwd()"/>    
    
    <p id="rePwdErrMsg" class="errMsg hide">비밀번호가 일치하지 않습니다.</p>
    <input type="password" id="mbRePassword" maxlength="15" class="input" placeholder="Confirm Password" onkeyup="SignUp.checkInputRePwd()"/>
    
    <p id="nameErrMsg" class="errMsg hide">이름을 입력해주세요.</p>
    <input type="text" id="mbName" class="input" placeholder="Your Name"  maxlength="10" onkeyup="SignUp.checkInputName()"/>
    
    <button id="signUpBtn" class="joinBtn" onclick="SignUp.callSignUp()" disabled>
        <span>SIGN UP</span>
        <i class="fas fa-arrow-right"></i>
    </button>
    
    <p class="signupGuide">OR</p>
    
    <a class="goSignView" href="/SignIn/SignInView">
        Don't have an account?
        <span>Sign in</span>
    </a>
</div>
    
<script>
    const SignUp = {
        
        /* 아이디 유효성 검사 */
        checkInputId: function(){
            let $mbId = $('#mbId'),
                $checkSameIdBtn = $('#checkSameIdBtn'),
                $idErrMsg1 = $('#idErrMsg1'),
                $idErrMsg2 = $('#idErrMsg2');
            
            this.checkField();
            
            if($mbId.val().length < 5){
                $checkSameIdBtn.removeClass('active');
                $idErrMsg1.removeClass('hide');
                $idErrMsg2.addClass('hide');
            }else{                
                $checkSameIdBtn.addClass('active');
                $idErrMsg1.addClass('hide');
                $idErrMsg2.removeClass('hide');
            }
        },
                
        /* 아이디 중복체크 */
        checkSameId: async function(){
            let $mbId = $('#mbId'),
                $idErrMsg2 = $('#idErrMsg2'),
                $checkSameIdBtn = $('#checkSameIdBtn');
            
            if($mbId.val().length < 5){                
                util.showAlert("아이디는 5자이상 입력해주세요.", () => $mbId.focus());
                return;
            }
            
            const checkSameIdRes = await util.postJson('/SignUp/CheckSameId', {
                mbId : $mbId.val()
            });
            
            if(!checkSameIdRes.result){
                util.showAlert(checkSameIdRes.msg, () => $mbId.focus());
                return;
            }
            
            util.showAlert("사용가능한 아이디입니다.")
            .then(() => {
                $mbId.attr('disabled', true);
                $idErrMsg2.addClass('hide');
                $checkSameIdBtn.attr('disabled', true);                
                $checkSameIdBtn.attr('data-checked', 'Y');
                $checkSameIdBtn.removeClass('active');
                
                $('#mbPassword').focus();
            });
        },
        
        /* 비밀번호 유효성 검사 */
        checkInputPwd: function(){
            let $mbPassword = $('#mbPassword'),
                $mbRePassword = $('#mbRePassword'),
                $rePwdErrMsg = $('#rePwdErrMsg'),
                $pwdErrMsg = $('#pwdErrMsg');
            
            this.checkField();
            
            if($mbPassword.val().length < 6){                
                $pwdErrMsg.removeClass('hide');
            }else{
                $pwdErrMsg.addClass('hide');
            }
            
            if($mbPassword.val() == $mbRePassword.val()){                
                $rePwdErrMsg.addClass('hide');
            }
        },
        
        /* 재입력 비밀번호 유효성 검사 */
        checkInputRePwd: function(){
            let $mbPassword = $('#mbPassword'),
                $mbRePassword = $('#mbRePassword'),
                $rePwdErrMsg = $('#rePwdErrMsg');
            
            this.checkField();
            
            if($mbPassword.val() != $mbRePassword.val()){                
                $rePwdErrMsg.removeClass('hide');
            }else{
                $rePwdErrMsg.addClass('hide');
            }
        }, 
        
        /* 이름 유효성 검사 */
        checkInputName: function(){
            let $mbName = $('#mbName'),                
                $nameErrMsg = $('#nameErrMsg');
            
            this.checkField();
            
            if($mbName.val().length < 1){                
                $nameErrMsg.removeClass('hide');
            }else{
                $nameErrMsg.addClass('hide');
            }                        
        },
        
        /* 모든 필드 유효성 검사 */
        checkField: function(){
            let $mbId = $('#mbId'),
                $mbPassword = $('#mbPassword'),
                $mbRePassword = $('#mbRePassword'),
                $mbName = $('#mbName'),
                $signUpBtn = $('#signUpBtn'),
                $checkSameIdBtn = $('#checkSameIdBtn');
                        
            let isAllCheck = 
            (
                $mbId.val().length >= 5 &&
                $checkSameIdBtn.attr('data-checked') == 'Y' &&
                $mbPassword.val().length >= 6 &&
                $mbPassword.val() == $mbRePassword.val() &&
                $mbName.val().length >= 1
            );
            
            /* 모든 조건에 맞으면 */
            if(isAllCheck){
                $signUpBtn.addClass('active');
                $signUpBtn.attr('disabled', false);
            }else{
                $signUpBtn.removeClass('active');
                $signUpBtn.attr('disabled', true);
            }
            
            return isAllCheck;
        },
        
        /* 회원가입 요청 */
        callSignUp: async function(){
            let $mbId = $('#mbId'),
                $mbPassword = $('#mbPassword'),
                $mbName = $('#mbName');
            
            if(!this.checkField()){
                showAlert("모든 필드의 조건에 맞게 입력해주세요.");
                return;
            }
            
            const callSignUpRes = await util.postJson('/SignUp/CallSignUp', {
                mbId : $mbId.val(),
                mbPassword : $mbPassword.val(),
                mbName : $mbName.val()
            });
            
            if(!callSignUpRes.result){
                util.showAlert(callSignUpRes.msg);
                return;
            }
            
            util.showAlert("회원가입이 완료되었습니다.<br>로그인 후 이용해주세요.")
            .then(() => {
                location.replace('/SignIn/SignInView');
            });
        }
    };
</script>