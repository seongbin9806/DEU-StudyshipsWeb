<div id="Reserv">
    <div class="topSeatBox">
        <div class="seatBtn yesActiveSeat"></div>
        <span>선택 가능</span>
        <div class="seatBtn choiceSeat"></div>
        <span>선택 좌석</span>
        <div class="seatBtn noActiveSeat"></div>
        <span>선택 불가</span>
    </div>
    
    <div class="seatWrap">
    <?
    $maxX = $this->config->item('maxX'); // 30
    $maxY = $this->config->item('maxY'); // 20

    for($y=0; $y<$maxY; $y++){
        echo '<div class="seatBoxWrap">';
        
        for($x=0; $x<$maxX; $x++){
            
            $seatIdx = 0;
            $seatNumber = 0;
            $isActive = "";
            
            foreach($seatList as $key => $data){                
                if($data['coordX'] == $x && $data['coordY'] == $y){
                    $seatIdx = $data['seatIdx'];
                    $seatNumber = $data['seatNumber'];
                    $isActive = $data['isActive'];                    
                    break;
                }
            }
    ?>
            <button class="seatBtn <?=$isActive?>" 
                    onclick="Reserv.CheckIsUseSeat('<?=$isActive?>', <?=$seatIdx?>, <?=$seatNumber?>)" 
                    data-seatNumber="<?=$seatNumber?>">
                <?=empty($seatNumber)? '' : $seatNumber?>
            </button>
    <?     }
        echo '</div>';
    }
    ?>
    </div>
    
    <div id="seatPaymentTab" class="seatPaymentTab hide">
        <div class="seatInfoTab">
            <input type="hidden" id="seatIdx"/>
            <p>선택한 좌석 번호 : <strong id="seatNumber"></strong>번</p>
            <p>사용여부 : 사용가능</p>
        </div>
        
        <button class="goReservPayViewBtn" onclick="Reserv.GoReservPaymentView()">선택한 좌석 결제하기</button>
    </div>        
</div>

<script>
    const Reserv = {
        /* 좌석 사용중 여부체크 */
        CheckIsUseSeat: async function(isActive, seatIdx, seatNumber){
            if(isActive == '' || isActive == 'N') return;            
            
            const CheckIsUseSeatRes = await util.postJson('/Seat/CheckIsUseSeat', {
                seatIdx: seatIdx
            });
            
            /* false일 경우 메세지 출력 */
            if(!CheckIsUseSeatRes.result){
                util.showAlert(CheckIsUseSeatRes.msg);
                return;
            }
            
            /* 좌석 번호, 사용 가능 출력 */
            $('.seatBtn').removeClass('choice');
            $(`.seatBtn[data-seatNumber="${seatNumber}"]`).addClass('choice');                        
            $('#seatNumber').text(seatNumber);
            $('#seatIdx').val(seatIdx);
            
            this.ShowSeatpaymentTab();
        },
        /* 좌석 결제하기 버튼 노출 */        
        ShowSeatpaymentTab: function(){
            $('#seatPaymentTab').removeClass('hide');            
        },
        /* 좌석 결제하기 화면으로 이동 */
        GoReservPaymentView: function(){
            let seatNumber = $('#seatNumber').text(),
                seatIdx = $('#seatIdx').val();
            
            location.href = `/SeatPayment/ReservPayment/${seatNumber}/${seatIdx}`;
        }
    }
</script>
