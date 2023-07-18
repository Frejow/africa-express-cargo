<?php include 'app/common/customer/1stpart.php'; ?>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Notifications</h3>
    </div>
    <div class="list-group list-group-flush list-group-hoverable">
        <?php
        $notifications = getNotifications($data['id']);
        if (!empty($notifications)) {
            foreach ($notifications as $key => $notification) {

        ?>
                <div class="list-group-item <?= 'notification' . $notification['id'] ?> <?= $notification['is_active'] == 1 ? 'bg-orange-lt' : '' ?>" data-notification-class="<?= 'notification' . $notification['id'] ?>">
                    <div class="row align-items-center">
                        <div class="col-auto"><span class="status-dot <?= $notification['is_active'] == 1 ? 'status-dot-animated' : '' ?> bg-secondary d-block"></span></div>
                        <div class="col text-truncate">
                            <span class="text-body d-block"><?= $notification['type'] . ' [ ' . date("d/m/Y h:i", strtotime($notification['created_at']))  . ' ]' ?></span>
                            <div class="d-block text-muted text-truncate mt-n1">
                                <?= $notification['message'] ?>
                            </div>
                        </div>
                        <div class="col-auto">
                            <a href="#" class="list-group-item-actions delete-icon" data-notification-id="<?= $notification['id'] ?>" title="Supprimer" data-bs-toggle="tooltip" data-bs-placement="left">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon text-danger" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M4 7h16"></path>
                                    <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12"></path>
                                    <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3"></path>
                                    <path d="M10 12l4 4m0 -4l-4 4"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
        <?php
            }
        }
        ?>
    </div>
</div>

<?php include 'app/common/customer/2ndpart.php' ?>