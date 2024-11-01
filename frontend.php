<div class="panel panel-default wdiget" id="menu-list">
    <h1><?php echo get_bloginfo('name'); ?></h1>
    <h2 class="panel-heading">Tagesteller - in der aktuellen Woche </h2>
    <div class="panel-body">
         <?php echo $week_interval; ?>
    </div>
    
    <ul class="list-group tagesteller-menu widget_meta">
        <?php foreach( $weekmenu as $date => $dishes ): $i = 0; ?>  
        <?php if( empty( $dishes ) ) continue; ?>
        <li class="list-group-item" <?php echo date( 'Y-m-d' ) == date( 'Y-m-d', $date )?'style="background:#ccc;"':''; ?>>
            <strong class="tagesteller-daydate"><?php echo date( 'l d.m.\'y', $date ); ?></strong><br />
            <?php if( $options['soup'] == 1 ): ?>
                <?php if( ! empty( $dishes[$i]['name'] ) ): ?> 
                <span class="dish-entry soup">
                    Suppe
                    <strong><?php echo $dishes[$i]['name']; ?></strong>
                    <span style="font-size:smaller;">
                        <?php echo empty( $dishes[$i]['price'] ) ? '' : ", " .number_format( $dishes[$i]['price'], 2, ',', '.' ). " EUR"; ?><br />
                    </span>
                </span>
            <?php endif; endif; ?>
            <?php $i++; if( $options['starter'] == 1 ):?>
                <?php if( ! empty( $dishes[$i]['name'] ) ): ?> 
                <span class="dish-entry starter">
                    Vorspeise
                    <strong><?php echo $dishes[$i]['name']; ?></strong>
                    <span style="font-size:smaller;">
                        <?php echo empty( $dishes[$i]['price'] ) ? '' : ", " .number_format( $dishes[$i]['price'], 2, ',', '.' ). " EUR"; ?><br />
                    </span>
                </span>
            <?php endif; endif; ?>
            <?php $i++; if( $options['maindish1'] == 1 ):  ?>
                <?php if( ! empty( $dishes[$i]['name'] ) ): ?> 
                <span class="dish-entry maindish1">
                    1. Speise
                    <strong><?php echo $dishes[$i]['name']; ?></strong>
                    <span style="font-size:smaller;">
                        , <?php echo number_format( $dishes[$i]['price'], 2, ',', '.' ); ?> EUR<?php echo included_text( $options, $dishes ); ?><br />
                    </span>
                </span>
            <?php endif; endif; ?>
            <?php $i++; if( $options['maindish2'] == 1 ): ?>
                <?php if( ! empty( $dishes[$i]['name'] ) ): ?> 
                <span class="dish-entry maindish2">
                    2. Speise
                    <strong><?php echo $dishes[$i]['name']; ?></strong>
                    <span style="font-size:smaller;">
                        , <?php echo number_format( $dishes[$i]['price'], 2, ',', '.' ); ?> EUR<?php echo included_text( $options, $dishes ); ?><br />
                    </span>
                </span>
            <?php endif; endif; ?>
            <?php $i++; if( $options['maindish3'] == 1 ): ?>
                <? if( ! empty( $dishes[$i]['name'] ) ): ?> 
                <span class="dish-entry maindish3">
                    3. Speise
                    <strong><?php echo $dishes[$i]['name']; ?></strong>
                    <span style="font-size:smaller;">
                        , <?php echo number_format( $dishes[$i]['price'], 2, ',', '.'); ?> EUR<?php echo included_text( $options, $dishes ); ?><br />
                    </span>
                </span>
            <?php endif; endif; ?>
            <?php $i++; if( $options['veggy'] == 1 ): ?>
                <?php if( ! empty( $dishes[$i]['name'] ) ): ?> 
                <span class="dish-entry veggy">
                    vegetarisches Gericht
                    <strong><?php echo $dishes[$i]['name']; ?></strong>
                    <span style="font-size:smaller;">
                        , <?php echo number_format( $dishes[$i]['price'], 2, ',', '.' ); ?> EUR<?php echo included_text( $options, $dishes ); ?><br />
                    </span>
                </span>
            <?php endif; endif; ?>
            <?php $i++; if( $options['dessert'] == 1 ):?>
                <?php if( ! empty( $dishes[$i]['name'] ) ): ?> 
                <span class="dish-entry dessert">
                    Nachspeise / Dessert
                    <strong><?php echo $dishes[$i]['name']; ?></strong>
                    <span style="font-size:smaller;">
                        <?php echo empty( $dishes[$i]['price'] ) ? '' : ", ".number_format( $dishes[$i]['price'], 2, ',', '.'). " EUR"; ?><br />
                    </span>  
                </span>
            <?php endif; endif; ?>
        </li>
        <?php endforeach; ?>
    </ul>
    <?php if( is_user_logged_in() ): ?>
        <div id="print-button">
            <br />
            <input type="button" value="Wochenkarte Drucken" onclick="print_elem('#menu-list')" />
            <br /><br />
        </div>
    <?php endif; ?>
</div>

<? 
function included_text( $options, $dishes ){
    $_return = "";
    
    if( $options['soup'] == 1 && empty( $dishes[0]['price'] ) ){ 
        $soup = " Suppe ";
    } else {
        $soup = false;
    }
    if( $options['starter'] == 1 && empty( $dishes[1]['price'] ) ){
        $starter = " Vorspeise ";
    } else { 
        $starter = false;
    }
    if( $options['dessert'] == 1 && empty( $dishes[count( $dishes )-1]['price'] ) ){
        $dessert = " Nachspeise ";
    } else {
        $dessert = false;
    }
    
    if($soup || $starter || $dessert){
        
        $_return .= "<br />&nbsp; inkl. ";
        
        if( $soup) $_return .= $soup;
        if( $starter && ! $soup && ! $dessert){
            $_return .= $starter;
        }
        if( $starter && $soup && ! $dessert){
            $_return .= " oder ".$starter;
        }
        if( $starter && $soup && $dessert){
            $_return .= ", ".$starter . " oder ".$dessert;
        }
        if( $starter && ! $soup && $dessert){
            $_return .= " oder ".$dessert;
        }
        if( ! $starter && ! $soup && $dessert){
            $_return .= $dessert;
        }
        
    }
    
    return $_return;
}
?>
<? if( is_user_logged_in() ): ?>
    <script type="text/javascript">
        
        function print_elem( elem ){
            var element = jQuery( elem ).clone( true );
            element.find( '#print-button' ).remove();
            tt_popup( element.html() );
        }

        function tt_popup(data){
            //console.log(data);
        
            var mywindow = window.open( '', 'Tagesteller', 'height=1024,width=768' );
            mywindow.document.write( '<html><head><title>Tagesteller</title>' );
            /*optional stylesheet*/ //
            mywindow.document.write( '<link rel="stylesheet" href="<?php echo plugins_url( 'css/flat.min.css?ver=1.7.4', __FILE__ ); ?>" type="text/css" />' );
            mywindow.document.write( '</head><body style="font-size: 11px !important;" >' );
            mywindow.document.write( data );
            mywindow.document.write( '</body></html>' );

            mywindow.document.close(); // necessary for IE >= 10
            mywindow.focus(); // necessary for IE >= 10

            setTimeout(mywindow.print(), 2000);
            //mywindow.print();
            //mywindow.close();

            return true;
        }
    </script>
<? endif; ?>