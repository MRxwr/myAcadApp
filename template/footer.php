</main>
    <!-- footer -->
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-lg-5 col-sm-4 col-6 mt_40">
                    <h3>Site Map</h3>
                    <ul class="site_map">
                        <li><a href="?v=Home">HOME</a></li>
                        <li><a href="?v=Subscriptions">SUBSICRIPTIONS</a></li>
                        <li><a href="?v=Profile">PROFILE</a></li>
                        <li><a href="?v=Privacy">PRIVACY POLICY</a></li>
                        <li><a href="?v=Terms">TERMS & CONDITIONS</a></li>
                    </ul>
               </div>
                <div class="col-lg-3 col-sm-4 col-6 mt_40">
                    <h3>Social Media</h3>
                    <ul class="social_media">
                        <li><a href="#"><img src="img/what.svg" alt="">WhatsApp</a></li>
                        <li><a href="#"><img src="img/ins.svg" alt=""></i>Instagram</a></li>
                        <li><a href="#"><img src="img/you.svg" alt="">Youtube</a></li>
                    </ul>
                </div>
                <div class="col-lg-4 col-sm-4 col-12 mt_40">
                   <div class="foot_wapper">
                       <p>© 2022-23 MY ACAD</p>
                       <a href="?v=Home" class="f_logo">
                           <img src="img/logo.png" alt="">
                       </a>
                   </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- back to top -->
    <a href="#" class="back-to-top"><i class="fal fa-angle-up"></i></a>
    
    <!-- all js here -->
    <script src="js/jquery-3.4.1.min.js"></script>
    <script src="js/plugins.js"></script>
    <script src="js/main.js"></script>
    <script>
        $(document).on("click","input[type=radio]",function(){
            $("input[type=number]").val(0);
        })
        $(document).ready(function() {
            $('.share').on('click', function() {
                var id = $(this).attr("id");
                var title = $(".title"+id).html();
                var invoice = $(".invoice"+id).html();
                if (navigator.share) {
                    // Use the Web Share API
                    navigator.share({
                        title: 'MY ACAD',
                        text: title,
                        url: 'https://createkwservers.com/myacad1/?v=Success&OrderID=' + invoice
                    })
                    .then(() => {
                        console.log('Shared successfully');
                    })
                    .catch((error) => {
                        console.error('Error sharing:', error);
                    });
                } else {
                    // Fallback behavior for browsers that do not support the Web Share API
                    alert('Sharing is not supported on this device/browser.');
                }
            });
        });
    </script>
</body>
</html>