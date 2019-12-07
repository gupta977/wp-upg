<?php
/*
### Admin custom post type management ####
*/
class upg_FormEntries
{

    public static function init()
    {
        $class = __CLASS__;
        new $class;
    }

    public function __construct()
    {
        //construct what you see fit here...
        add_filter('page_row_actions', array($this, 'changeRowActions'), 10, 2);

        add_action('trashed_post', array($this, 'redirectAfterTrashing'), 10);

        add_action('admin_init', array($this, 'markRead'));
        add_filter('display_post_states', array($this, 'displayUnreadState'));



        //Mark as read/unread
        add_action('load-post.php', array($this, 'customActions'));
        //Notices when changed
        add_action('admin_notices', array($this, 'customAdminNotices'));
        //Notification unread bubble
        //add_action('admin_menu', array( $this, 'notification_bubble' ));
        add_filter('add_menu_classes', array($this, 'cpt_notification_bubble'));
        //adding read/unread at bulk filter
        add_action('admin_footer-edit.php', array($this, 'appendCustomBulkActions'));
        //working for bulk action
        add_filter('bulk_actions-edit-form-entries', array($this, 'changeBulkActions'));
        add_action('load-edit.php', array($this, 'customBulkActions'));
    }



    public function displayViewPage()
    {
        if (!empty($_GET['post'])) {
            $post = get_post($_GET['post']);
            echo $this->getTemplate('admin/form-view', $post);
        }
    }

    public function getEntryId($post_id)
    {
        return get_post_meta($post_id, 'entry_id', true);
    }


    public function redirectAfterTrashing($post_id)
    {
        global $pagenow;

        if (get_post_type($post_id) == 'upg' && $pagenow == 'post.php' && empty($_GET['download_csv'])) {
            wp_redirect(admin_url("edit.php?post_type=upg"));
            exit;
        }
    }

    public function changeRowActions($actions, $post)
    {
        if (get_post_type() === 'upg' && empty($_GET['download_csv'])) {
            $post_status = !empty($_GET['post_status']) ? $_GET['post_status'] : '';
            $res = array();
            switch ($post_status) {
                case '':
                case 'all':
                case 'publish':
                case 'draft':
                    $res['view'] = '<a title="View" href="' . get_permalink($post->ID) . '">View</a>';
                    if ($post->post_status == 'draft') {
                        $res['publish'] = '<a title="Mark as publish" href="' . admin_url('post.php?post=' . $post->ID . '&action=publish' . (!empty($post_status) ? '&post_status=' . $post_status : '')) . '">Mark as publish</a>';
                    } else {
                        $res['draft'] = '<a title="Mark as draft" href="' . admin_url('post.php?post=' . $post->ID . '&action=draft' . (!empty($post_status) ? '&post_status=' . $post_status : '')) . '">Mark as draft</a>';
                    }
                    if (!empty($actions['trash'])) {
                        $res['trash'] = $actions['trash'];
                    }

                    if (!empty($actions['edit'])) {
                        $res['edit'] = $actions['edit'];
                    }


                    if (!empty($actions['inline hide-if-no-js'])) {
                        $res['inline hide-if-no-js'] = $actions['inline hide-if-no-js'];
                    }

                    break;
                default:
                    $res = $actions;
                    break;
            }

            $actions = $res;
        }
        return $actions;
    }

    public function markRead($a)
    {
        global $pagenow;
        if ($pagenow == 'admin.php' && !empty($_REQUEST['page']) && $_REQUEST['page'] == 'view-entry') {
            if (!empty($_REQUEST['post'])) {
                wp_update_post(
                    array(
                        'ID'           => $_REQUEST['post'],
                        'post_status'   =>  'publish',
                    )
                );
            }
        }
    }


    public function displayUnreadState($states)
    {
        global $post;
        global $post_type;

        if ($post_type == 'upg') {
            $arg = get_query_var('post_status');
            if ($arg != 'draft') {
                if ($post->post_status == 'draft') {
                    return array('draft');
                }
            }
        }
        return $states;
    }

    public function customActions()
    {
        $post_id = !empty($_GET['post']) ? $_GET['post'] : NULL;
        $action = !empty($_GET['action']) ? $_GET['action'] : NULL;
        $post_status = !empty($_GET['post_status']) ? $_GET['post_status'] : NULL;

        switch ($action) {
            case 'publish':
                if (!empty($post_id)) {
                    $post = get_post($post_id);

                    $args = array(
                        'ID' => $post_id,
                        'post_status' => 'publish',
                    );
                    wp_update_post($args);

                    $count_posts = wp_count_posts($post->post_type);
                    $sendback = add_query_arg(array('post_type' => $post->post_type), admin_url('edit.php'));
                    if (!empty($post_status) && $count_posts->$post_status > 0) {
                        $sendback = add_query_arg(array('post_status' => $post_status), $sendback);
                    }
                    $sendback = add_query_arg(array('published' => 1, 'ids' => $post_id), $sendback);

                    wp_redirect($sendback);
                    exit();
                }
                break;
            case 'draft':
                if (!empty($post_id)) {
                    $post = get_post($post_id);

                    $args = array(
                        'ID' => $post_id,
                        'post_status' => 'draft',
                    );
                    wp_update_post($args);

                    $count_posts = wp_count_posts($post->post_type);
                    $sendback = add_query_arg(array('post_type' => $post->post_type), admin_url('edit.php'));
                    if (!empty($post_status) && $count_posts->$post_status > 0) {
                        $sendback = add_query_arg(array('post_status' => $post_status), $sendback);
                    }
                    $sendback = add_query_arg(array('drafted' => 1, 'ids' => $post_id), $sendback);

                    wp_redirect($sendback);
                    exit();
                }
                break;
        }
    }

    public function customAdminNotices()
    {

        global $post_type, $pagenow;

        if ($pagenow == 'edit.php' && $post_type == 'upg' && empty($_GET['download_csv'])) {
            if (isset($_REQUEST['published']) && (int) $_REQUEST['published'] > 1) {
                $message = $_REQUEST['published'] . ' entries was marked as Read';
                echo '<div class="updated"><p>' . $message . '</p></div>';
            } elseif (isset($_REQUEST['published']) && (int) $_REQUEST['published'] = 1) {
                $message = $_REQUEST['published'] . ' entry was marked as publish';
                echo '<div class="updated"><p>' . $message . '</p></div>';
            } elseif (isset($_REQUEST['drafted']) && (int) $_REQUEST['drafted'] > 1) {
                $message = $_REQUEST['drafted'] . ' entries was marked as draft';
                echo '<div class="updated"><p>' . $message . '</p></div>';
            } elseif (isset($_REQUEST['drafted']) && (int) $_REQUEST['drafted'] = 1) {
                $message = $_REQUEST['drafted'] . ' entry was marked as draft';
                echo '<div class="updated"><p>' . $message . '</p></div>';
            }
        }
    }
    public function count_unread()
    {
        return 22;
    }

    public function notification_bubble()
    {
        global $menu;
        $pending_items = $this->count_unread();

        $menu[3][0] .= $pending_items ? " <span class='update-plugins count-1' title='title'><span class='update-count'>$pending_items</span></span>" : '';
    }

    public function cpt_notification_bubble($menu)
    {
        $types = array("upg"); //You can provide the name of your post type here .e.g, array("POST_SLUG_HERE","clients")
        $statuses = array("unread", "draft", "pending"); // Here you can provide the statuses that you want to count and show.
        foreach ($types as $type) {
            $count = 0;
            foreach ($statuses as $status) {
                $num_posts = wp_count_posts($type, 'readable');
                if (!empty($num_posts->$status))
                    $count += $num_posts->$status;
                // build string to match in $menu array
                if ($type == 'post') {
                    $menu_str = 'edit.php';
                } else {
                    $menu_str = 'edit.php?post_type=' . $type;
                }
            }
            // loop through $menu items, find match, add indicator
            foreach ($menu as $menu_key => $menu_data) {
                if ($menu_str != $menu_data[2])
                    continue;
                $menu[$menu_key][0] .= " <span class='update-plugins count-$count'><span class='plugin-count'>" . number_format_i18n($count) . '</span></span>';
            }
        }
        return $menu;
    }
    public function appendCustomBulkActions()
    {
        global $post_type;

        if ($post_type == 'upg' && empty($_GET['download_csv'])) {
            $post_status = !empty($_GET['post_status']) ? $_GET['post_status'] : '';

            ?>
                    <script type="text/javascript">
                        jQuery(document).ready(function($) {
                            <?php if (empty($post_status) || $post_status == 'draft' || $post_status == 'all') : ?>
                                $('<option>').val('publish').text('<?php _e('Mark as publish') ?>').insertBefore("select[name='action'] option[value=trash]");
                                $('<option>').val('publish').text('<?php _e('Mark as publish') ?>').insertBefore("select[name='action2'] option[value=trash]");
                            <?php endif; ?>
                            <?php if (empty($post_status) || $post_status == 'publish' || $post_status == 'all') : ?>
                                $('<option>').val('draft').text('<?php _e('Mark as draft') ?>').insertBefore("select[name='action'] option[value=trash]");
                                $('<option>').val('draft').text('<?php _e('Mark as draft') ?>').insertBefore("select[name='action2'] option[value=trash]");
                            <?php endif; ?>
                        });
                    </script>
                <?php
                        }
                    }

                    public function changeBulkActions($actions)
                    {
                        $post_status = !empty($_GET['post_status']) ? $_GET['post_status'] : '';
                        switch ($post_status) {
                            case '':
                            case 'all':
                            case 'publish':
                            case 'draft':
                                $res = array(
                                    'trash' => $actions['trash'],
                                );
                                break;
                            default:
                                $res = $actions;
                                break;
                        }
                        return $res;
                    }
                    public function customBulkActions()
                    {
                        $post_ids = !empty($_GET['post']) ? $_GET['post'] : NULL;
                        $post_type = !empty($_GET['post_type']) ? $_GET['post_type'] : NULL;

                        if (!empty($post_ids) && $post_type == 'upg') {
                            check_admin_referer('bulk-posts');
                            $action = ($_GET['action'] == -1) ? $_GET['action2'] : $_GET['action'];

                            switch ($action) {
                                case 'publish':
                                    $process = 0;
                                    foreach ($post_ids as $post_id) {
                                        $post = get_post($post_id);

                                        $args = array(
                                            'ID' => $post_id,
                                            'post_status' => 'publish',
                                        );
                                        wp_update_post($args);
                                        $process++;
                                    }

                                    $count_posts = wp_count_posts($post_type);
                                    $sendback = add_query_arg(array('post_type' => $post_type), admin_url('edit.php'));
                                    if (!empty($post_status) && $count_posts->$action > 0) {
                                        $sendback = add_query_arg(array('post_status' => $action), $sendback);
                                    }
                                    $sendback = add_query_arg(array('published' => $process, 'ids' => join(',', $post_ids)), $sendback);

                                    wp_redirect($sendback);
                                    exit();
                                    break;
                                case 'draft':
                                    $process = 0;
                                    foreach ($post_ids as $post_id) {
                                        $post = get_post($post_id);

                                        $args = array(
                                            'ID' => $post_id,
                                            'post_status' => 'draft',
                                        );
                                        wp_update_post($args);
                                        $process++;
                                    }

                                    $count_posts = wp_count_posts($post_type);
                                    $sendback = add_query_arg(array('post_type' => $post_type), admin_url('edit.php'));
                                    if (!empty($post_status) && $count_posts->$action > 0) {
                                        $sendback = add_query_arg(array('post_status' => $action), $sendback);
                                    }
                                    $sendback = add_query_arg(array('drafted' => $process, 'ids' => join(',', $post_ids)), $sendback);

                                    wp_redirect($sendback);
                                    exit();
                                    break;
                                default:
                                    return;
                            }
                        }
                    }
                }
                ?>