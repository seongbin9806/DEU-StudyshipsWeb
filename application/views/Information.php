<div id="Information">
    <div class="profileBox">
        <img class="profile" src="/assets/image/ico_profile.jpg"/>
    </div>
    
    <div class="myInfoBox">
        <p>이름 : <?=$this->session->userdata('member')['mbName']?></p>
        <p>가입날짜 : <?= (new DateTime($this->session->userdata('member')['regDate']))->format('Y-m-d') ?></p>
    </div>
    
    <p class="title">에약한 좌석번호 및 예약시간</p>
    
    <? if(empty($seatInfo)){ ?>
        <p class="content">예약된 좌석이 존재하지 않습니다.</p>
    <? }else{ ?>
        <p class="content2">좌석번호 : <?=$seatInfo['seatNumber']?>번</p>
        <p class="content2">예약시간 : <?=$seatInfo['startDateTime']?> ~ <?=$seatInfo['endDateTime']?></p>        
    <? } ?>
    
    <div class="btnBox">
        <a class="goPayListBtn">결제 내역확인</a>
    </div>
</div>