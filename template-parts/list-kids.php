<?php
/**
 * Template part that lists all cool kids
 */

$current_user = wp_get_current_user();

$kid = new ClassKid;
$role = $kid->getRole($current_user);
if (!(in_array('coolest_kid', $role) || in_array('cooler_kid', $role))) {
    die();
}

if (in_array('coolest_kid', $role)) {
    $kidrole = 'Coolest Kid';
}
else if (in_array('cooler_kid', $role)) {
    $kidrole = 'Cooler Kid';
}

$users = get_users( [ 'role__in' => [ 'cool_kid', 'cooler_kid', 'coolest_kid' ] ] );
?>
<div id="list-kids" class="row">
    <?php
foreach ($users as $user) { 
    $kidList = new ClassKid;
    ?>
    <div class="col-12 col-md-3">
        <div class="card card-kid">
            <div class="card-body">
                <h5 class="card-title"><?php echo esc_html($kidList->getName($user)) . ' ' . esc_html($kidList->getLastname($user)); ?></h5>
                <p class="card-text">Country: <?php echo esc_html($kidList->getCountry($user)); ?></p>
                <?php
                if ( 'Coolest Kid' === $kidrole ) { ?>
                    <p class="card-text">Email: <?php echo esc_html($kidList->getEmail($user)); ?></p>
                    <p class="card-text">Role: <?php echo esc_html($kidList->getRole($user)[0]); ?></p>
                <?php }
                ?>
            </div>
        </div>
    </div>
<?php } ?>
</div>

