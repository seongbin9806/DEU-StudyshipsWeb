<div id="ReservPayment">
    <p class="guide">예약시간</p>
    <input id="seatStartTime" class="reservInput" type="time" onchange="ReservPayment.ChangeStartTime()"/>
    
    <div id="seatUseTimeTab" class="hide">
        <p class="guide">사용시간</p>
        
        <? foreach($this->config->item('useTime') as $key => $data){ ?>
            <div class="tab useTimeTab" data-index="<?=$key?>" onclick="ReservPayment.ChangeSeatUseTime(<?=$key?>)">
                <div><?=$data['hour']?>시간</div>
                <div><?=number_format($data['amount'])?>원</div>
            </div>
        <? } ?>
    </div>
    
    <div id="defaultTab" class="hide">
        <input id="seatIdx" type="hidden" value="<?=$this->uri->segment(4)?>"/>
        
        <p class="guide">선택 정보</p>
        
        <div class="tab">
            <div>좌석</div>
            <div><?=$this->uri->segment(3)?>번</div>
        </div>
        
        <div class="tab">
            <div>이용시간</div>
            <div>
                <p id="startDateTime">-</p>
                <p>~</p>
                <p id="endDateTime">-</p>
            </div>
        </div>
        
        <div class="tab">
            <div>사용 시간 및 결제금액</div>
            <div><span id="hour">-</span>시간 / <span id="amount">-</span>원</div>
        </div>
        
        <div class="payBtnTab">
            <button class="payBtn card" onclick="ReservPayment.SeatPayment('card')">카드결제 <i class="fas fa-credit-card"></i></button>
            <button class="payBtn cash" onclick="ReservPayment.SeatPayment('cash')">현금/계좌이체 <i class="fas fa-wallet"></i></button>
        </div>
    </div>
</div>

<script>
    const ReservPayment = {        
        ChangeStartTime: function(){
            let $seatStartTime = $('#seatStartTime'),            
                now = new Date(),
                hours = now.getHours(),
                minutes = now.getMinutes();                        

            // 시간과 분이 두 자릿수가 되도록 포맷팅
            hours = hours < 10 ? '0' + hours : hours;
            minutes = minutes < 10 ? '0' + minutes : minutes;
                                    
            let nowTime = hours + ':' + minutes;
            
            if(nowTime > $seatStartTime.val()){
                util.showAlert("예약시간을 현재 시간 이후로 설정해주세요.");
                $('#seatUseTimeTab').addClass('hide');
                $('#defaultTab').addClass('hide');
                return;
            }
            
            this.ActiveSeatUseTimeTab();
            
            if($('.useTimeTab.active').length >= 1){
                this.ActiveDefaultTab();
            }
        },
        ActiveSeatUseTimeTab: function(index){
            $('#seatUseTimeTab').removeClass('hide');
        },
        ChangeSeatUseTime: function(index){
            this.useTimeIndex = index;
            
            $('.useTimeTab').removeClass('active');
            $(`.useTimeTab[data-index="${this.useTimeIndex}"]`).addClass('active');
            
            this.ActiveDefaultTab();
        },
        AddHoursToDate: function(dateString, hours) {
            // 입력된 날짜 문자열을 Date 객체로 변환
            const date = new Date(dateString.replace(' ', 'T') + ':00'); // 초를 추가하여 ISO 형식으로 변환

            // Date 객체에 시간을 더함
            date.setHours(date.getHours() + hours);

            // 새로 계산된 날짜를 원하는 형식으로 반환
            const year = date.getFullYear();
            let month = date.getMonth() + 1, // 월은 0부터 시작하므로 1을 더해줌
                day = date.getDate(),
                hoursNew = date.getHours(),
                minutes = date.getMinutes();

            // 월, 일, 시간, 분이 두 자릿수가 되도록 포맷팅
            month = month < 10 ? '0' + month : month;
            day = day < 10 ? '0' + day : day;
            hoursNew = hoursNew < 10 ? '0' + hoursNew : hoursNew;
            minutes = minutes < 10 ? '0' + minutes : minutes;

            return `${year}-${month}-${day} ${hoursNew}:${minutes}`;
        },
        ActiveDefaultTab: function(){
            let startTime = $("#seatStartTime").val(),
                now = new Date(),
                year = now.getFullYear(),
                month = now.getMonth() + 1, // 월은 0부터 시작하므로 1을 더해줌
                day = now.getDate();

            // 월과 일이 두 자릿수가 되도록 포맷팅
            month = month < 10 ? '0' + month : month;
            day = day < 10 ? '0' + day : day;
        
            let hour = this.useTime[this.useTimeIndex]['hour'],
                amount = util.addComma(this.useTime[this.useTimeIndex]['amount']),
                date = `${year}-${month}-${day}`,
                startDateTime = `${date} ${startTime}`,
                endDateTime = this.AddHoursToDate(startDateTime, this.useTime[this.useTimeIndex]['hour']);
            
            $('#hour').text(hour);
            $('#amount').text(amount);
            $('#startDateTime').text(startDateTime);
            $('#endDateTime').text(endDateTime);
            
            $('#defaultTab').removeClass('hide');
        },
        SeatPayment: async function(payType) {
            let seatIdx = $('#seatIdx').val(),
                hour = this.useTime[this.useTimeIndex]['hour'],
                amount = this.useTime[this.useTimeIndex]['amount'],
                startDateTime = $('#startDateTime').text() + ':00',
                endDateTime = $('#endDateTime').text() + ':00';
            
            if(payType == 'cash'){
                await util.showAlert(`계좌번호 : 1000-0060-4541<br/>은행 : 토스뱅크<br/>입금금액 : ${util.addComma(amount)}원`);                
            }
            
            const SeatPaymentRes = await util.postJson('/SeatPayment/Payment', {
                seatIdx : seatIdx,
                hour : hour,
                amount : amount,
                startDateTime : startDateTime,
                endDateTime : endDateTime,
                payType : payType
            });
            
            if(!SeatPaymentRes.result){
                util.showAlert(SeatPaymentRes.msg);
                return;
            }
            
            util.showAlert("결제가 완료되었습니다.")
            .then(() => {
                location.replace('/Mypage/Information');
            });
        },
        useTimeIndex: 0,
        useTime: <?=json_encode($this->config->item('useTime'))?>
    }
</script>