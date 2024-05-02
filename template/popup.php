<!-- Trigger/Open The Modal -->
<button style='display: none;' id="myBtn">Open Modal</button>

<!-- The Modal -->
<div id="myModal" class="modal">

  <!-- Modal content -->
  <div class="modal-content">
    <span class="close">&times;</span>
    <img class='popupimg' src='https://excelrecall.com.sv/assets/img/mitsubishi-popup-2.png' alt='img-po-up' style='width: 100%; height: auto;' />
  </div>

</div>


<style>

/* The Modal (background) */
.modal {
  display: none; /* Hidden by default */
  position: fixed; /* Stay in place */
  z-index: 10000000; /* Sit on top */
  padding-top: 50px; /* Location of the box */
  left: 0;
  top: 0;
  width: 100%; /* Full width */
  height: 100%; /* Full height */
  overflow: auto; /* Enable scroll if needed */
  background-color: rgb(0,0,0); /* Fallback color */
  background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
}

/* Modal Content */
.modal-content {
  background-color: #fefefe;
  margin: auto;
  padding: 10px;
  border: 1px solid #888;
  width: 75%;
}

/* The Close Button */
.close {
  color: #aaaaaa;
  float: right;
  font-size: 28px;
  font-weight: bold;
}

.close:hover,
.close:focus {
  color: #000;
  text-decoration: none;
  cursor: pointer;
}
</style>

<?php

//Condion para cargar ppop-up en página de inicio

if (!isset($_GET['msjcls6'])) {

	echo "
      <script>
        // Get the modal
        var modal = document.getElementById('myModal');

        // Get the button that opens the modal
        var btn = document.getElementById('myBtn');

        // Get the <span> element that closes the modal
        var span = document.getElementsByClassName('close')[0];

        // When the user clicks the button, open the modal 
        btn.onclick = function() {
          modal.style.display = 'block';
        }

        // When the user clicks on <span> (x), close the modal
        span.onclick = function() {
          modal.style.display = 'none';
        }

        // When the user clicks anywhere outside of the modal, close it
        window.onclick = function(event) {
          if (event.target == modal) {
            modal.style.display = 'none';
          }
        }

        $(document).one('ready', function () { 
          $('#myBtn').trigger('click'); 
        });

      </script>   

		 ";
}







