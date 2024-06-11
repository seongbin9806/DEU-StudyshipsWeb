const util = {
    showLoadingBar: function() {
        let mask = `<div id='mask'></div>`,
            lodingTop = window.pageYOffset,
            loadingImg = `<div id='loadingImg' style='position: absolute; top: calc(50% + ${lodingTop}px); left: 50%; transform: translate(-50%, -50%); z-index:1051'>
                            <img src='/assets/image/loading.gif?animation=spin' style='width:80px; border-radius: 30%;'>
                          </div>`;

        $('body').append(mask).append(loadingImg);
        $('#mask').css({
            'width': '100%', 'height': '100vh', 'opacity': '0.3', position: 'absolute', top: $(window).scrollTop(), left: 0, background: '#898989'
        });
    },
    hideLoadingBar: function() {
        $('#mask, #loadingImg').remove();
    },
    postJson: function(url, data, isLoading = true) {
        return new Promise((resolve, reject) => {

            if (isLoading) this.showLoadingBar();
            setTimeout(() => {
                $.ajax({
                    type: 'post',
                    url: url,
                    dataType: 'json',
                    contentType: "application/x-www-form-urlencoded;charset=utf-8",
                    async: false,
                    data: data,
                    beforeSend: function(xhr) {},
                    success: function(data) {
                        resolve(data);
                    },
                    complete: () => {
                        if (isLoading) this.hideLoadingBar();
                    },
                    error: function(request, status, error) {
                        alert("code:" + request.status + "\n" + "message:" + request.responseText + "\n" + "error:" + error);
                    }
                });
            }, 100);
        });
    },
    showAlert: function(message, destroyEvent) {
        return swal.fire({
            html: message,
            confirmButtonText: '확인',
            didDestroy: () => {
                if (destroyEvent) destroyEvent();
            }
        });
    },
    showConfirm: function(message) {
        return Swal.fire({
            html: message,
            confirmButtonText: '확인',
            denyButtonText: '취소',
            showDenyButton: true
        });
    },
    addComma: function(number) {
        return number.toLocaleString();
    },
    removeComma: function(str) {
        return str.replace(/,/g, '');
    }
}
