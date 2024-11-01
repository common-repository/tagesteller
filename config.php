<div class="wrap">
    <div class="icon32" style="background: url('<?php echo plugins_url( 'icon_big.png', __FILE__ ); ?>') no-repeat center center; " ><br></div>
    <h2>Tagesteller &rsaquo; Einstellungen</h2>

    <form name="tt-form-options" id="tt-form-options" action="?page=tt-pi-options" method="post">
        <input type="hidden" name="action" value="tt-options-form" />
        <p>
            Basiseinstellungen
        </p>
        <table class="form-table">
            <?php if( $options['permission'] == 0 ): ?>
                <tr>
                    <th scope="row">
                        Call-Home für Service Verbesserung
                    </th>
                    <td>
                        <fieldset>
                            <label for="permission">
                                <input type="checkbox" name="permission" id="permission" value="permission"  <?php echo $options['permission'] == 1 ? 'checked' : ''; ?> /> 
                                das Plugin darf E-Mail Adresse und Web-Adresse der Wordpress Installation auslesen und an den Server der Entwickler übertragen.<br />
                                <p class="description">
                                    Außerdem weisen wir dich darauf hin, dass die Menü Einträge auch an unseren Server übermittelt werden.
                                    <br /> Mehr Infos dazu auf der Wordpress Plugin Übersichtsseite
                                </p>
                            </label>
                    </td>
                </tr>
            <?php endif; ?>
            <tr valign="top">
                <th scope="row"><label for="mg-formname">An diesen Wochentagen gibt es ein Menü</label></th>
                <td>
                    <fieldset>
                        <legend class="screen-reader-text">
                            <span>Wochentage</span>
                        </legend>
                        <label for="tt-monday">
                            <input type="checkbox" name="dish-day[]" id="tt-monday" value="monday" <?php echo $options['monday']== 1 ? 'checked' : ''; ?> />
                            Montag
                        </label>
                        <br />
                        
                        <label for="tt-thuesday">
                            <input type="checkbox" name="dish-day[]" id="tt-thuesday" value="thuesday" <?php echo $options['thuesday'] == 1 ? 'checked' : ''; ?> />
                            Dienstag
                        </label>
                        <br />
                        
                        <label for="tt-wensday">
                            <input type="checkbox" name="dish-day[]" id="tt-wensday" value="wensday" <?php echo $options['wensday'] == 1 ? 'checked' : ''; ?> />
                            Mittwoch
                        </label>
                        <br />
                        
                        <label for="tt-thursday">
                            <input type="checkbox" name="dish-day[]" id="tt-thursday" value="thursday" <?php echo $options['thursday'] == 1 ? 'checked' : ''; ?> />
                            Donnerstag
                        </label>
                        <br />
                        
                        <label for="tt-friday">
                            <input type="checkbox" name="dish-day[]" id="tt-friday" value="friday" <?php echo $options['friday'] == 1 ? 'checked' : ''; ?> />
                            Freitag
                        </label>
                        <br />
                        
                        <label for="tt-saturday">
                            <input type="checkbox" name="dish-day[]" id="tt-saturday" value="saturday" <?php echo $options['saturday'] == 1 ? 'checked' : ''; ?> />
                            Samstag
                        </label>
                        <br />
                        
                        <label for="tt-sunday">
                            <input type="checkbox" name="dish-day[]" id="tt-sunday" value="sunday" <?php echo $options['sunday'] == 1 ? 'checked' : ''; ?> />
                            Sonntag
                        </label>
                        
                        <p class="description">An welchen Tagen gibt es einen Tagesteller bzw. ein Tagesangebot/Mittagsmenü?</p>
                    </fieldset>
                   
                </td>
            </tr>
                        
            <tr valign="top">
                <th scope="row">Diese Feldgruppen werden jeweils angezeigt</th>
                <td>
                    <fieldset>
                        <legend class="screen-reader-text">
                            <span>Diese Feldgruppen werden jeweils angezeigt</span>
                        </legend>
                        <label for="fieldgroup-1">
                            <input type="checkbox" name="fieldgroups[]" id="fieldgroup-1" value="soup"  <?php echo $options['soup'] == 1 ? 'checked' : ''; ?> /> 
                            Suppe
                        </label>
                        <br />

                        <label for="fieldgroup-2">
                            <input type="checkbox" name="fieldgroups[]" id="fieldgroup-2" value="starter" <?php echo $options['starter'] == 1 ? 'checked' : ''; ?> /> 
                            Vorspeise
                        </label>
                        <br />

                        <label for="fieldgroup-3">
                            <input type="checkbox" name="fieldgroups[]" id="fieldgroup-3" value="maindish1" <?php echo $options['maindish1'] == 1 ? 'checked' : ''; ?> /> 
                            Hauptspeise 1
                        </label>
                        <br />

                        <label for="fieldgroup-4">
                            <input type="checkbox" name="fieldgroups[]" id="fieldgroup-4" value="maindish2" <?php echo $options['maindish2'] == 1 ? 'checked' : ''; ?> /> 
                            Hauptspeise 2
                        </label>
                        <br />

                        <label for="fieldgroup-5">
                            <input type="checkbox" name="fieldgroups[]" id="fieldgroup-5" value="maindish3" <?php echo $options['maindish3'] == 1 ? 'checked' : ''; ?> /> 
                            Hauptspeise 3
                        </label>
                        <br />

                        <label for="fieldgroup-6">
                            <input type="checkbox" name="fieldgroups[]" id="fieldgroup-6" value="veggy" <?php echo $options['veggy'] == 1 ? 'checked' : ''; ?> /> 
                            Vegetarisches Gericht
                        </label>
                        <br />

                        <label for="fieldgroup-7">
                            <input type="checkbox" name="fieldgroups[]" id="fieldgroup-7" value="dessert" <?php echo $options['dessert'] == 1 ? 'checked' : ''; ?> /> 
                            Nachspeise
                        </label>
                        <br />

                        <p class="description">
                            Sollte das Menü in Ihrem Restaurant nicht abbildbar sein dann schreiben Sie uns
                            damit wir diesen auch Fall berücksichtigen können: <a href="mailto:feedback@tagesteller.entsteht.at?subject=feature-request">Mail Senden.</a>
                        </p>
                    </fieldset>
                </td>
            </tr>
            <?php if( $options['permission'] == 1 ): ?>
                <tr>
                    <th scope="row">
                        Call-Home für Service Verbesserung
                    </th>
                    <td>
                        <fieldset>
                            <label for="permission">
                                <input type="checkbox" name="permission" id="permission" value="permission"  <?php echo $options['permission'] == 1 ? 'checked' : ''; ?> /> 
                                das Plugin darf E-Mail Adresse und Web-Adresse der Wordpress Installation auslesen und an den Server der Entwickler übertragen.<br />
                                <p class="description">
                                    Außerdem weisen wir dich darauf hin, dass die Menü Einträge auch an unseren Server übermittelt werden.
                                    <br /> Mehr Infos dazu auf der Wordpress Plugin Übersichtsseite
                                </p>
                            </label>
                    </td>
                </tr>
            <?php endif; ?>
        </table>
        
        <!--p>
            Erweiterte Einstellungen
        </p-->
        
        <p class="submit"><input type="submit" name="submit" id="submit" class="button-primary" value="Einstellungen speichern"  /></p>
    </form>
</div>
