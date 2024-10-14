<?php
/**
 * Template part that lists all cool kids
 */

use CoolKidsNetwork\Classes\ClassKid\ClassKid;

$current_user = wp_get_current_user();

$kid = new ClassKid;
$role = $kid->getRole($current_user);
if (!(in_array('administrator', $role) || in_array('coolest_kid', $role) || in_array('cooler_kid', $role))) {
    die();
}

if (in_array('coolest_kid', $role)) {
    $currentkidrole = 'Coolest Kid';
}
else if (in_array('cooler_kid', $role)) {
    $currentkidrole = 'Cooler Kid';
}
else if (in_array('administrator', $role)) {
    $currentkidrole = 'Administrator';
}

$users = get_users( [ 'role__in' => [ 'cool_kid', 'cooler_kid', 'coolest_kid' ] ] );
?>
<div id="list-kids" class="row">
    <?php
foreach ($users as $userkid) { 
    $kidList = new ClassKid;
    $kidrolelist = $kidList->getRole($userkid);


    if (in_array('coolest_kid', $kidrolelist)) {
        $kidrole = 'Coolest Kid';
    }
    else if (in_array('cooler_kid', $kidrolelist)) {
        $kidrole = 'Cooler Kid';
    }
    else if (in_array('cool_kid', $kidrolelist)) {
        $kidrole = 'Cool Kid';
    }

    ?>
    <div class="col-12 col-md-4">
        <div class="card card-kid">
            <div class="card-body">
                <h2 class="card-title"><?php echo esc_html($kidList->getName($userkid)) . ' ' . esc_html($kidList->getLastname($userkid)); ?></h2>
                <p class="card-text">Country: <?php echo esc_html($kidList->getCountry($userkid)); ?></p>
                <?php
                if ( 'Administrator' === $currentkidrole || 'Coolest Kid' === $currentkidrole) { ?>
                    <p class="card-text">Email: <?php echo esc_html($kidList->getEmail($userkid)); ?></p>
                    <p class="card-text">Role: <?php echo esc_html($kidrole); ?></p>
                <?php }
                if ('Administrator' === $currentkidrole) { ?>
                    <div class="change-role">
                        <p>Change role to:</p>
                        <?php
                        if ('Cool Kid' !== $kidrole) {
                            echo "<button type='button' class='upgrade-kid-role' aria-label='Change to Cool Kid' data-kidemail='".$kidList->getEmail($userkid)."' data-role='cool_kid' name='Change to Cool Kid'>Cool Kid</button>";
                        }

                        if ('Cooler Kid' !== $kidrole) {
                            echo "<button type='button' class='upgrade-kid-role' aria-label='Change to Cooler Kid' data-kidemail='".$kidList->getEmail($userkid)."' data-role='cooler_kid' name='Change to Cooler Kid'>Cooler Kid</button>";
                        }

                        if ('Coolest Kid' !== $kidrole) {
                            echo "<button type='button' class='upgrade-kid-role' aria-label='Change to Coolest Kid' data-kidemail='".$kidList->getEmail($userkid)." 'data-role='coolest_kid' name='Change to Coolest Kid'>Coolest Kid</button>";
                        }
                        ?>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
<?php } ?>
</div>

