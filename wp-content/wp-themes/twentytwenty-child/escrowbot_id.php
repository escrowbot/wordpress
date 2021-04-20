<?php
    /* Template Name: escrowbot_id */

    // security
    $escrowbot_id = strtolower(get_query_var( 'escrowbot_id' ));//string
    $idcolumn = substr($escrowbot_id,0,1) === 'w' ? 'wspid' : 'fbid';
    if( preg_match('/^([0-9]{5,30})$/',$escrowbot_id) ) {
        wp_redirect( 'https://escrowbot.io/f'.$escrowbot_id );
    }
    if( !preg_match('/^(f|w)?([0-9]{5,30})$/',$escrowbot_id) ) {
        give_404();
    }

    
    try{
        $user = get_user($escrowbot_id);
    }catch (Exception $e) {
        give_404();
    }

    //title
    add_filter( 'pre_get_document_title', function ($title) {
        return "Perfil ".get_query_var( 'escrowbot_id' );
    });

    get_header();

    $confidentes = get_confidentes($escrowbot_id);
    $confiantes = get_confiantes($escrowbot_id);

    
?>

<main id="site-content" role="main">

<header class="entry-header has-text-align-center header-footer-group">

	<div class="entry-header-inner section-inner medium">

		<h4 class="entry-title">ID #<?php echo($escrowbot_id); ?></h4>
	</div><!-- .entry-header-inner -->

</header>

<div class="post-inner thin ">
    <div class="entry-content">
        <script type='text/javascript'>
            function SubmitForm() {
                let escrowbot_id = document.getElementById('escrowbot_id').value;

                //check val for length / valid IP here

                window.location.href='/' + escrowbot_id;
                return false;
            }
        </script>
        <form method="get" action="/" onsubmit="return SubmitForm()">
            <input type="text" placeholder="id" id="escrowbot_id" name="escrowbot_id" value="<?php echo($escrowbot_id); ?>">
            <input type="submit" value="INSPECCIONAR ID" style="width: 100%;">
        </form>


        <?php
            if(substr($escrowbot_id,0,1) === 'f') {//facebook
        ?>
            <h2>Perfil</h2>
            <p>
                Nombre: <?php echo $user->fbname; ?><br/>
                Facebook: <a target="_blank" href="https://facebook.com/<?php echo $user->fbprofileurl; ?>">facebook.com/<?php echo $user->fbprofileurl; ?></a><br/>
                ID: <?php echo $user->$idcolumn; ?><br/>
                En escrowbot desde <?php echo date('M/Y', strtotime($user->fecha)); ?>
            </p>

            <?php if(!count($confiantes)) { ?>
            <h4>Confiantes</h4>
            <p>Nadie confía en <?php echo $user->fbname; ?>.</p>
            <?php }else{ ?>
            <h4>Confían en <?php echo $user->fbname; ?>:</h4>
            <?php foreach($confiantes as $confidencia) { $confiante = get_user($confidencia->usuario_confiado); ?>
            <p>
                Nombre: <?php echo $confiante->fbname; ?><br/>
                Facebook: <a target="_blank" href="https://facebook.com/<?php echo $confiante->fbprofileurl; ?>">facebook.com/<?php echo $confiante->fbprofileurl; ?></a><br/>
                ID: <a href="/<?php echo $confiante->$idcolumn; ?>"><?php echo $confiante->$idcolumn; ?></a><br/>
                En escrowbot desde <?php echo date('M/Y', strtotime($user->fecha)); ?><br/>
                <i>referencia de hace <?php echo ago_function($confidencia->fecha); ?></i>
            </p>
            <?php } ?>
            <?php } ?>

            <?php if(!count($confidentes)) { ?>
            <h4>Confidentes</h4>
            <p><?php echo $user->fbname; ?> no confía en nadie.</p>
            <?php }else{ ?>
            <h4><?php echo $user->fbname; ?> confía en:</h4>
            <?php foreach($confidentes as $confidencia) { $confidente = get_user($confidencia->usuario_confidente); ?>
            <p>
                Nombre: <?php echo $confidente->fbname; ?><br/>
                Facebook: <a target="_blank" href="https://facebook.com/<?php echo $confidente->fbprofileurl; ?>">facebook.com/<?php echo $confidente->fbprofileurl; ?></a><br/>
                ID: <a href="/<?php echo $confidente->$idcolumn; ?>"><?php echo $confidente->$idcolumn; ?></a><br/>
                En escrowbot desde <?php echo date('M/Y', strtotime($user->fecha)); ?><br/>
                <i>referencia de hace <?php echo ago_function($confidencia->fecha); ?></i>
            </p>
            <?php } ?>
            <?php } ?>



        <?php
            }else{//wsp
        ?>
            <h2>Perfil</h2>
            <p>
                ID: <?php echo $user->$idcolumn; ?><br/>
                Nombre: <?php echo $user->wspname; ?><br/>
                Contacto: <a target="_blank" href="https://wa.me/<?php echo $user->$idcolumn; ?>">wa.me/<?php echo $user->$idcolumn; ?></a><br/>
                En escrowbot desde <?php echo date('M/Y', strtotime($user->fecha)); ?>
            </p>

            <?php if(!count($confiantes)) { ?>
            <h4>Confiantes</h4>
            <p>Nadie confía en <?php echo $user->wspname; ?>(<?php echo $user->$idcolumn; ?>).</p>
            <?php }else{ ?>
            <h4>Confían en <?php echo $user->wspname; ?>(<?php echo $user->$idcolumn; ?>):</h4>
            <?php foreach($confiantes as $confidencia) { $confiante = get_user($confidencia->usuario_confiado); ?>
            <p>
                Nombre: <?php echo $confiante->wspname; ?><br/>
                Contacto: <a target="_blank" href="https://wa.me/<?php echo $confiante->$idcolumn; ?>">wa.me/<?php echo $confiante->$idcolumn; ?></a><br/>
                ID: <a href="/<?php echo $confiante->$idcolumn; ?>"><?php echo $confiante->$idcolumn; ?></a><br/>
                En escrowbot desde <?php echo date('M/Y', strtotime($user->fecha)); ?><br/>
                <i>referencia de hace <?php echo ago_function($confidencia->fecha); ?></i>
            </p>
            <?php } ?>
            <?php } ?>

            <?php if(!count($confidentes)) { ?>
            <h4>Confidentes</h4>
            <p><?php echo $user->wspname; ?>(<?php echo $user->$idcolumn; ?>) no confía en nadie.</p>
            <?php }else{ ?>
            <h4><?php echo $user->wspname; ?>(<?php echo $user->$idcolumn; ?>) confía en:</h4>
            <?php foreach($confidentes as $confidencia) { $confidente = get_user($confidencia->usuario_confidente); ?>
            <p>
                Nombre: <?php echo $confidente->wspname; ?><br/>
                Contacto: <a target="_blank" href="https://wa.me/<?php echo $confidente->$idcolumn; ?>">wa.me/<?php echo $confidente->$idcolumn; ?></a><br/>
                ID: <a href="/<?php echo $confidente->$idcolumn; ?>"><?php echo $confidente->$idcolumn; ?></a><br/>
                En escrowbot desde <?php echo date('M/Y', strtotime($user->fecha)); ?><br/>
                <i>referencia de hace <?php echo ago_function($confidencia->fecha); ?></i>
            </p>
            <?php } ?>
            <?php } ?>

        <?php
            }
        ?>

    </div>
</div>

</main>

<?php get_template_part( 'template-parts/footer-menus-widgets' ); ?>

<?php get_footer(); ?>