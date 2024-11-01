<?php
    if( empty( $_GET['tab'] ) ){
        $_GET['tab'] = "";
    }
    if( empty( $_GET['date'] ) ){
        $_GET['date'] = "";
    }
?>
<div class="wrap">
    <div class="icon32" style="background: url('<?php echo plugins_url( 'icon_big.png', __FILE__ ); ?>') no-repeat center center; " ><br></div>
    <h2>
        Tagesteller - in der Woche 
        &nbsp; 
        <a href="?page=tt-pi&date=<?php echo date( 'Y-m-d', mktime(0, 0, 0, date( "m", strtotime($wdate) )  , date( "d", strtotime( $wdate ) ) -7, date( "Y", strtotime( $wdate ) ) ) ); ?>" title="vorige Woche"><i class="fa fa-caret-left"></i></a>
        &nbsp; <?php echo $week_interval; ?> &nbsp; 
        <a href="?page=tt-pi&date=<?php echo date( 'Y-m-d', mktime(0, 0, 0, date( "m", strtotime($wdate) )  , date( "d", strtotime( $wdate ) ) +7, date( "Y", strtotime( $wdate ) ) ) ); ?>" title="nächste Woche"><i class="fa fa-caret-right"></i></a>
    </h2>
    <?php tt_admin_tabs( $wdate, $_GET['tab'] ); ?>
    
<br />
    <form name="tt-form-dishes" id="tt-form-options" action="?page=tt-pi&tab=<?php echo $_GET['tab']?>&date=<?php echo $_GET['date']?>" method="post">
        <input type="hidden" name="action" value="tt-options-dishes" />
        <input type="hidden" name="tab" value="<?php echo $_GET['tab']?>" />
        <input type="hidden" name="date" value="<?php echo $_GET['date']?>" />
        
<!--todo: generic creation from db config table -->
        <table class="form-table">
            <tr valign="top" class="odd">
                <th scope="row"><label for="mg-formname">Feiertag</label></th>
                <td>
                    <fieldset>
                        <legend class="screen-reader-text">
                            <span>Feiertag</span>
                        </legend>
                        <label for="tt-holiday">
                            <input type="checkbox" name="holiday" id="tt-holiday" value="1" />
                            Feiertag
                        </label>
                        <p class="description">Der Tag wird dann gekennzeichnet?</p>
                    </fieldset>
                   
                </td>
            </tr>
            <?php if( $options['soup'] == 1 ): ?>
            <tr valign="top" class="even">
                <th scope="row"><label for="tt-soup">Suppe</label></th>
                <td>
                    <fieldset>
                        <legend class="screen-reader-text">Suppe</legend>
                        <label>
                            Bezeichnung
                            <input name="soup" type="text" id="tt-soup" placeholder="Suppe" class="regular-text" value="<?php echo ! empty( $dishes[0] ) ? $dishes[0]['name'] : ''; ?>" />
                        </label>
                        <br />
                        <label>
                            Preis
                            <input name="soup-price" type="text" id="tt-soup-price" class="small-text" value="<?php echo ! empty( $dishes[0] ) ? $dishes[0]['price'] : '' ; ?>"  /> €
                        </label>
                        <p class="description">* Preis bei Suppe, Vorspeise und Nachspeise leer lassen oder 0 eintragen, wenn im Menü inkludiert.</p>
                    </fieldset>
                </td>
            </tr>
            <?php endif; ?>
            <?php if( $options['starter'] == 1 ): ?>
            <tr valign="top" class="odd">
                <th scope="row"><label for="tt-starter">Vorspeise</label></th>
                <td>
                    <label>
                        Bezeichnung
                        <input name="starter" type="text" id="tt-starter" placeholder="Vorspeise" class="regular-text" value="<?php echo ! empty( $dishes[1] ) ? $dishes[1]['name'] : ''; ?>" />
                    </label>
                    <br />
                    <label>
                        Preis
                        <input name="starter-price" type="text" id="tt-starter-price" class="small-text" value="<?php echo ! empty( $dishes[1] ) ? $dishes[1]['price'] : ''; ?>" /> €
                    </label>
                    <p class="description">* Preis bei Suppe, Vorspeise und Nachspeise leer lassen oder 0 eintragen, wenn im Menü inkludiert.</p>
                </td>
            </tr>
            <?php endif; ?>
            <?php if( $options['maindish1'] == 1 ): ?>
            <tr valign="top" class='even'>
                <th scope="row"><label for="tt-maindish1">Hauptspeise 1</label></th>
                <td>
                    <label>
                        Bezeichnung
                        <input name="maindish1" type="text" id="tt-maindish1" placeholder="Hauptspeise" class="regular-text" value="<?php echo ! empty( $dishes[2] ) ? $dishes[2]['name'] : ''; ?>" />
                    </label>
                    <br />
                    <label>
                        Preis
                        <input name="maindish1-price" type="text" id="tt-maindish1-price" class="small-text" value="<?php echo ! empty( $dishes[2] ) ? $dishes[2]['price'] : ''; ?>" /> €
                    </label>
                </td>
            </tr>
            <?php endif;?>
            <?php if( $options['maindish2'] == 1 ): ?>
            <tr valign="top" class='odd'>
                <th scope="row"><label for="tt-maindish2">Hauptspeise 2</label></th>
                <td>
                    <label>
                        Bezeichnung
                        <input name="maindish2" type="text" id="tt-maindish2" placeholder="Hauptspeise" class="regular-text" value="<?php echo ! empty( $dishes[3] ) ? $dishes[3]['name'] : ''; ?>" />
                    </label>
                    <br />
                    <label>
                        Preis
                        <input name="maindish2-price" type="text" id="tt-maindish2-price" class="small-text" value="<?php echo ! empty( $dishes[3] ) ? $dishes[3]['price'] : ''; ?>" /> €
                    </label>
                </td>
            </tr>
            <?php endif; ?>
            <?php if( $options['maindish3'] == 1 ): ?>
            <tr valign="top" class='even'>
                <th scope="row"><label for="tt-maindish3">Hauptspeise 3</label></th>
                <td>
                    <label>
                        Bezeichnung
                        <input name="maindish3" type="text" id="tt-maindish3" placeholder="Hauptspeise" class="regular-text" value="<?php echo ! empty( $dishes[4] ) ? $dishes[4]['name'] : ''; ?>" />
                    </label>
                    <br />
                    <label>
                        Preis
                        <input name="maindish3-price" type="text" id="tt-maindish3-price" class="small-text" value="<?php echo ! empty( $dishes[4] ) ? $dishes[4]['price'] : ''; ?>" /> €
                    </label>
                </td>
            </tr>
            <?php endif;?>
            <?php if( $options['veggy'] == 1 ): ?>
            <tr valign="top" class='odd'>
                <th scope="row"><label for="tt-maindish3">Vegetarisches Gericht</label></th>
                <td>
                    <label>
                        Bezeichnung
                        <input name="veggy" type="text" id="tt-veggy" placeholder="Hauptspeise" class="regular-text" value="<?php echo ! empty( $dishes[5] ) ? $dishes[5]['name'] : ''; ?>" />
                    </label>
                    <br />
                    <label>
                        Preis
                        <input name="veggy-price" type="text" id="tt-veggy-price" class="small-text" value="<?php echo ! empty( $dishes[5] ) ? $dishes[5]['price'] : ''; ?>" /> €
                    </label>
                </td>
            </tr>
            <?php endif; ?>
            <?php if( $options['dessert'] == 1 ): ?>
            <tr valign="top" class='even'>
                <th scope="row"><label for="tt-desert">Nachspeise</label></th>
                <td>
                    <label>
                        Bezeichnung
                        <input name="desert" type="text" id="tt-soup" placeholder="Nachspeise" class="regular-text" value="<?php echo ! empty( $dishes[6] ) ? $dishes[6]['name'] : ''; ?>" />
                    </label>
                    <br />
                    <label>
                        Preis
                        <input name="desert-price" type="text" id="tt-desert-price" class="small-text" value="<?php echo ! empty( $dishes[6] ) ? $dishes[6]['price'] : ''; ?>" /> €
                    </label>
                    <p class="description">* Preis bei Suppe, Vorspeise und Nachspeise leer lassen oder 0 eintragen, wenn im Menü inkludiert.</p>
                </td>
            </tr>
            <?php endif; ?>
        </table>
        
        <p class="submit"><input type="submit" name="submit" id="submit" class="button-primary" value="Tagesteller speichern"  /></p>
    </form>
</div>

<script type="text/javascript">
    
<?php if( $options['permission'] == 1 ):
    if( empty( $options['token'] ) && empty( $_GET['reg'] ) ):?>
        var params = JSON.stringify({'email':"<?php echo get_bloginfo( 'admin_email' ); ?>", 'www':"<?php echo site_url(); ?>"});
        jQuery.ajax({
            url: "<?php echo TT_GC_URL; ?>",
            data: { action: "register", params: params },
            type: "get",
            success: function( data ){
                var result = data.split( '.' );
                if( result[0] === "OK" ){
                    var url = location.href + "&reg="+result[1];
                    location.href = url;
                } else {
                    //console.log( 'Beim Registrieren ist ein Fehler aufgetreten: ' );
                    //console.log( data );
                }
            },
            error: function(data){
                //console.log( "fehler: " );
                //console.log( data );
            }
        });
    <?php endif; ?>
    <?php if( ! empty( $_POST['action'] ) && $_POST['action'] == 'tt-options-dishes' ): ?>
        
        <?php $params = json_encode( array_merge( $_POST, array( 'token' => $options['token'] ) ) ); ?>
        var params = '<?php echo $params?>';
        
        jQuery.ajax({
            url: "<?php echo TT_GC_URL; ?>",
            data: { action: "save", params: params },
            type: "get",
            success: function( data ){
                //console.log("hat funktioniert. " + data);
            },
            error: function(data){
                //console.log("fehler: ");
                //console.log(data);
            }
        });

        <?php endif; ?>
<?php endif; ?>
    
   
</script>
