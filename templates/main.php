<div id="akismet-plugin-container">
    <div class="akismet-masthead">
        <div class="akismet-masthead__inside-container">
            <?php Akismet::view( 'logo' ); ?>
        </div>
    </div>
    <div class="akismet-lower">
        <?php Akismet_Admin::display_status();?>
        <div class="akismet-boxes">
            <?php

            if ( Akismet::predefined_api_key() ) {
                Akismet::view( 'predefined' );
            } else {
                Akismet::view( 'activate' );
            }

            ?>
        </div>
    </div>
</div>
