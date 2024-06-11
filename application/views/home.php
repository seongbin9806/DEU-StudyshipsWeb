<div id="home">
    <div class="mentBox">
        <div class="profileBox">
            <img class="profile" src="/assets/image/ico_profile.jpg"/>
        </div>
        <span>안녕하세요. <?=$this->session->userdata('member')['mbName']?>님!</span>
    </div>
    
    <div class="moveBox">
        <!--좌석예약 이동-->
        <a href="/Seat/Reserv" class="box box1">
            <div>
                <p class="title">좌석예약</p>
                <p class="subTitle">사용할 좌석을 선택하고 결제합니다.</p>
            </div>
            <div>
                <i class="fas fa-calendar-check"></i>
            </div>
        </a>
        
        <!--상품주문 이동-->
        <a class="box box2">
            <div>
                <p class="title">상품주문</p>
                <p class="subTitle">무인으로 운영되는 메뉴를 주문합니다.</p>
            </div>
            <div>
                <i class="fas fa-cookie-bite"></i>
            </div>
        </a>
        
        <!--내정보 이동-->
        <a href="/Mypage/Information" class="box box3">
            <div>
                <p class="title">내정보</p>
                <p class="subTitle">사용중인 좌석, 남은시간, 결제내역을 확인합니다.</p>
            </div>
            <div>
                <i class="fas fa-user-circle"></i>
            </div>
        </a>
    </div>
    
    <a class="btnLogout" href="/logout">로그아웃 <i class="fas fa-sign-out-alt"></i></a>
</div>