$(document).ready(function() {
    setInterval(function() {
        $.ajax({
            type: "get",
            url:"/get",
            success: function(result){
                var arrVal = result['value'];
                var arrData = result['data'];
                var x = 0;
                var tpm = document.getElementsByClassName('tpm');
                var kapasitas = document.getElementsByClassName('kapasitas');
                var prediksi = document.getElementsByClassName('prediksi');

                for(var i = 0; i<arrData.length; i++){
                    
                  if(arrData[i]['status']==1){
                    
                    for(var p = arrVal.length-1; p>=0; p--){
                        if(arrVal[p]['idPasien'] == arrData[i]['id']){
                            
                            tpm[x].innerHTML = arrVal[p]['tpm'];
                            kapasitas[x].innerHTML = arrVal[p]['kapasitas'];
                            prediksi[x].innerHTML = arrVal[p]['prediksi'];
                            x++;
                            break;
                        }
                    }

                  }
                 
                }

                
          
    
                
               
            }
        })
    }, 5000);
   });