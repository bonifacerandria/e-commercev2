
    <figure class="wp-block-table">
        <table>
            <tbody>
                <tr>
                    <td>ID de commande</td>
                    <td>
                        <?php
                                                error_log('METHOD UTILISé : '.$_SERVER['REQUEST_METHOD']);
                                                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                                                           // Récupérer les données depuis la requête GET ou POST
                                                           $donnees_recues = isset($_REQUEST['orderID']) ? sanitize_text_field($_REQUEST['orderID']) : '';
                                                        error_log('Données postées dans la page : /******************--[--'.$_REQUEST['orderID'].'--]----***********************/');
                                                           // Afficher les données s'il y en a
                                                           if (!empty($donnees_recues)) {
                                                                   echo esc_html($donnees_recues);
                                                           } else {
                                                                   echo 'Aucune donnée reçue.';
                                                           }
                                                }
               ?>
                    </td>
                </tr>
                <tr>
            <td>Nom du commerçant </td>
              <td>
                        <?php
                                                error_log('METHOD UTILISé : '.$_SERVER['REQUEST_METHOD']);
                                                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                                                           // Récupérer les données depuis la requête GET ou POST
                                                           $donnees_recues = isset($_REQUEST['outletAcronym']) ? sanitize_text_field($_REQUEST['outletAcronym']) : '';
                                                        error_log('Données postées dans la page outletAcronym : /******************--[--'.$_REQUEST['outletAcronym'].'--]----***********************/');
                                                           // Afficher les données s'il y en a
                                                           if (!empty($donnees_recues)) {
                                                                   echo esc_html($donnees_recues);
                                                           } else {
                                                                   echo 'Aucune donnée reçue.';
                                                           }
                                                }
               ?>
                    </td>
         </tr>
         <tr>
            <td>Commerçant ID</td>
            <td>
                        <?php
                                                error_log('METHOD UTILISé : '.$_SERVER['REQUEST_METHOD']);
                                                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                                                           // Récupérer les données depuis la requête GET ou POST
                                                           $donnees_recues = isset($_REQUEST['merchantID']) ? sanitize_text_field($_REQUEST['merchantID']) : '';
                                                        error_log('Données postées dans la page merchantID : /******************--[--'.$_REQUEST['merchantID'].'--]----***********************/');
                                                           // Afficher les données s'il y en a
                                                           if (!empty($donnees_recues)) {
                                                                   echo esc_html($donnees_recues);
                                                           } else {
                                                                   echo 'Aucune donnée reçue.';
                                                           }
                                                }
               ?>
                    </td>
         </tr>
         <tr>
            <td>ID Acquéreur </td>
             <td>
                        <?php
                                                error_log('METHOD UTILISé : '.$_SERVER['REQUEST_METHOD']);
                                                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                                                           // Récupérer les données depuis la requête GET ou POST
                                                           $donnees_recues = isset($_REQUEST['acquirerID']) ? sanitize_text_field($_REQUEST['acquirerID']) : '';
                                                        error_log('Données postées dans la page acquirerID : /******************--[--'.$_REQUEST['acquirerID'].'--]----***********************/');
                                                           // Afficher les données s'il y en a
                                                           if (!empty($donnees_recues)) {
                                                                   echo esc_html($donnees_recues);
                                                           } else {
                                                                   echo 'Aucune donnée reçue.';
                                                           }
                                                }
               ?>
                    </td>
         </tr>
         <tr>
            <td>Numéro de facture</td>
             <td>
                        <?php
                                                error_log('METHOD UTILISé : '.$_SERVER['REQUEST_METHOD']);
                                                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                                                           // Récupérer les données depuis la requête GET ou POST
                                                           $donnees_recues = isset($_REQUEST['referenceNumber']) ? sanitize_text_field($_REQUEST['referenceNumber']) : '';
                                                        error_log('Données postées dans la page referenceNumber : /******************--[--'.$_REQUEST['referenceNumber'].'--]----***********************/');
                                                           // Afficher les données s'il y en a
                                                           if (!empty($donnees_recues)) {
                                                                   echo esc_html($donnees_recues);
                                                           } else {
                                                                   echo 'Aucune donnée reçue.';
                                                           }
                                                }
               ?>
                    </td>
         </tr>
         <tr>
                        <td>Montant </td>
                         <td>
                                    <?php
                                                        error_log('METHOD UTILISé : '.$_SERVER['REQUEST_METHOD']);
                                                        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                                                                   // Récupérer les données depuis la requête GET ou POST
                                                                   $donnees_recues = isset($_REQUEST['purchaseAmountFormatted']) ? sanitize_text_field($_REQUEST['purchaseAmountFormatted']) : '';
                                                                error_log('Données postées dans la page purchaseAmountFormatted : /******************--[--'.$_REQUEST['purchaseAmountFormatted'].'--]----***********************/');
                                                                   // Afficher les données s'il y en a
                                                                   if (!empty($donnees_recues)) {
                                                                           echo esc_html($donnees_recues);
                                                                   } else {
                                                                           echo 'Aucune donnée reçue.';
                                                                   }
                                                        }
                           ?>
                                </td>
                     </tr>
                                 <tr>
                                    <td>Devise </td>
                                     <td>
                                                <?php
                                                                        error_log('METHOD UTILISé : '.$_SERVER['REQUEST_METHOD']);
                                                                        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                                                                                   // Récupérer les données depuis la requête GET ou POST
                                                                                   $donnees_recues = isset($_REQUEST['purchaseCurrencyAlphaCode']) ? sanitize_text_field($_REQUEST['purchaseCurrencyAlphaCode']) : '';
                                                                                error_log('Données postées dans la page purchaseCurrencyAlphaCode : /******************--[--'.$_REQUEST['purchaseCurrencyAlphaCode'].'--]----***********************/');
                                                                                   // Afficher les données s'il y en a
                                                                                   if (!empty($donnees_recues)) {
                                                                                           echo esc_html($donnees_recues);
                                                                                   } else {
                                                                                           echo 'Aucune donnée reçue.';
                                                                                   }
                                                                        }
                                       ?>
                                            </td>
                                 </tr>
                                 <tr>
            <td>Code raison</td>
               <td>
                        <?php
                                                error_log('METHOD UTILISé : '.$_SERVER['REQUEST_METHOD']);
                                                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                                                           // Récupérer les données depuis la requête GET ou POST
                                                           $donnees_recues = isset($_REQUEST['reasonCode']) ? sanitize_text_field($_REQUEST['reasonCode']) : '';
                                                        error_log('Données postées dans la page : /******************--[--'.$_REQUEST['reasonCode'].'--]----***********************/');
                                                           // Afficher les données s'il y en a
                                                           if (!empty($donnees_recues)) {
                                                                   echo esc_html($donnees_recues);
                                                           } else {
                                                                   echo 'Aucune donnée reçue.';
                                                           }
                                                }
               ?>
                    </td>
         </tr>
         
         <tr>
            <td>Description raison</td>
             <td>
                        <?php
                                                error_log('METHOD UTILISé : '.$_SERVER['REQUEST_METHOD']);
                                                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                                                           // Récupérer les données depuis la requête GET ou POST
                                                           $donnees_recues = isset($_REQUEST['reasonDesc']) ? sanitize_text_field($_REQUEST['reasonDesc']) : '';
                                                        error_log('Données postées dans la page REASON DESC : /******************--[--'.$_REQUEST['reasonDesc'].'--]----***********************/');
                                                           // Afficher les données s'il y en a
                                                           if (!empty($donnees_recues)) {
                                                                   echo esc_html($donnees_recues);
                                                           } else {
                                                                   echo 'Aucune donnée reçue.';
                                                           }
                                                }
               ?>
                    </td>
         </tr>

         <tr>
            <td>Numéro de carte</td>
             <td>
                        <?php
                                                error_log('METHOD UTILISé : '.$_SERVER['REQUEST_METHOD']);
                                                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                                                           // Récupérer les données depuis la requête GET ou POST
                                                           $donnees_recues = isset($_REQUEST['paddedCardNb']) ? sanitize_text_field($_REQUEST['paddedCardNb']) : '';
                                                        error_log('Données postées dans la page : /******************--[--'.$_REQUEST['paddedCardNb'].'--]----***********************/');
                                                           // Afficher les données s'il y en a
                                                           if (!empty($donnees_recues)) {
                                                                   echo esc_html($donnees_recues);
                                                           } else {
                                                                   echo 'Aucune donnée reçue.';
                                                           }
                                                }
               ?>
                    </td>
         </tr>
         
        
        
         
       

                         
            </tbody>
        </table>
    </figure>