<div class="seatWrap">
    <div class="topSeatBox">
        <div class="seatBtn choiceSeat"></div>
        <span>선택 좌석</span>
        <div class="seatBtn noActiveSeat"></div>
        <span>비활성화 좌석</span>
    </div>
    
<!--관리자 등록한 좌석 출력 (30 X 20) -->
<?
    $maxX = $this->config->item('maxX'); // 30
    $maxY = $this->config->item('maxY'); // 20
    
    for($y=0; $y<$maxY; $y++){
        echo '<div class="seatBoxWrap">';
        
        for($x=0; $x<$maxX; $x++){
            
            $seatNumber = 0;
            $clsIsActive = "";
                
            foreach($seatList as $key => $data){                
                if($data['coordX'] == $x && $data['coordY'] == $y){
                    $seatNumber = $data['seatNumber'];
                    $clsIsActive = $data['isActive'];                    
                    break;
                }
            }
?>
            <button class="seatBtn <?=$clsIsActive?>" 
                    onclick="SeatManagement.OpenSeatPopup(<?=$x?>, <?=$y?>)" 
                    data-x="<?=$x?>" 
                    data-y="<?=$y?>">
                <?=empty($seatNumber)? '' : $seatNumber?>
            </button>
<?     }
        echo '</div>';
    }  
?>
</div>


<div id="seatPopup" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-body">
				<p class="title">좌석 등록</p>
				<i class="fas fa fa-times" onclick="SeatManagement.CloseSeatPopup()"></i>
                
                <input type="hidden" id="coordX" value=""/>
                <input type="hidden" id="coordY" value=""/>
                
                <span class="guideWrap">
                    <p class="guideBox"><span class="circle">●</span>좌석 활성화</p>
                    <div class="contentBox">
                        <input type="checkbox" id="toggle" checked hidden> 

                        <label for="toggle" class="toggleSwitch">
                          <span class="toggleButton"></span>
                        </label>
                    </div>
                </span>
                
                <span class="guideWrap">
                    <p class="guideBox"><span class="circle">●</span>좌석 번호</p>
                    <div class="contentBox">
                        <input type="text" id="seatNumber" oninput="this.value=this.value.replace(/[^0-9]/g, '');" maxlength="3">
                    </div>
                </span>
                
                <div class="buttonBox">                    
                    <button class="btnCancel" onclick="SeatManagement.CloseSeatPopup()">Cancel</button>
                    <button class="btnOk" onclick="SeatManagement.SaveSeat()">Save</button>
                </div>
			</div>
		</div>
	</div>
</div>

<script>
    const SeatManagement = {
        // 등록시트팝업 열기
        OpenSeatPopup: function(coordX, coordY){            
            $('#coordX').val(coordX);
            $('#coordY').val(coordY);            
            $('.seatBtn').removeClass('choice');
            $(`.seatBtn[data-x="${coordX}"][data-y="${coordY}"]`).addClass('choice');
            $('#toggle').prop('checked', true);
            $('#seatNumber').val('');            
            $('#seatPopup').modal('show');
        },
        // 팝업 닫기
        CloseSeatPopup: function(){
            $('#seatPopup').modal('hide');
        },
        // 시트저장(등록)
        SaveSeat: async function(){
            let $coordX = $('#coordX'),
                $coordY = $('#coordY'),
                $seatNumber = $('#seatNumber'),
                $toggle = $('#toggle');            
            
            if(!$seatNumber.val()){
                util.showAlert("좌석번호를 입력하지 않았습니다.", () => $seatNumber.focus());
                return;
            }
            
            const SaveSeatRes = await util.postJson('/AdmSeatInsert/SaveSeat', {
                coordX : $coordX.val(),
                coordY : $coordY.val(),
                seatNumber : $seatNumber.val(),
                isActive : $toggle.is(':checked')? 'Y' : 'N'
            });
            
            if(!SaveSeatRes.result){
                util.showAlert(SaveSeatRes.msg);
                return;
            }
            
            util.showAlert("등록되었습니다.")
            .then(() => {
                location.reload(); 
            });
        }
    };
</script>