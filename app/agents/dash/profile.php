<?php
if (connected()) {
    $_SESSION['current_url'] = "http://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
}

include 'app/common/agents/1stpart.php'; ?>

<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col-auto">
                <a href="" class="modal-fade" data-bs-toggle="modal" data-bs-target="#previousimage">
                    <span class="avatar avatar-lg rounded" style="background-image: url(<?= $data[0]['avatar'] == 'null' ? PROJECT . 'public/images/default-user-profile.jpg' : $data[0]['avatar'] ?>)"></span>
                </a>
                <?php
                    if ($data[0]['avatar'] != 'null') {
                    ?>
                        <div class="modal fade" id="previousimage">
                            <div class="modal-dialog modal-dialog-centered modal-fullscreen-sm-down">
                                <div class="modal-content">
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    <img class="" src="<?= $data[0]['avatar'] == 'null' ? PROJECT . 'public/images/default-user-profile.jpg' : $data[0]['avatar'] ?>" alt="User profile picture">
                                </div>
                            </div>
                        </div>
                    <?php
                    }
                ?>
            </div>
            <div class="col">
                <h1 class="fw-bold"><?= $data[0]['first_names'] . ' ' . $data[0]['name'] ?></h1>
                <div class="my-2"><?= '@' . $data[0]['user_name'] ?>
                </div>
                <div class="list-inline list-inline-dots text-muted">
                    <div class="list-inline-item">
                        <!-- Download SVG icon from http://tabler-icons.io/i/map -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-inline" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M3 7l6 -3l6 3l6 -3l0 13l-6 3l-6 -3l-6 3l0 -13" />
                            <path d="M9 4l0 13" />
                            <path d="M15 7l0 13" />
                        </svg>
                        <?= $data[0]['country'] ?>
                    </div>
                    <div class="list-inline-item">
                        <!-- Download SVG icon from http://tabler-icons.io/i/mail -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-inline" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M3 5m0 2a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v10a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2z" />
                            <path d="M3 7l9 6l9 -6" />
                        </svg>
                        <?= $data[0]['mail'] ?>
                    </div>
                </div>
            </div>
            <div class="col-auto ms-auto">
                <div class="btn-list">
                    <a href="<?= redirect($_SESSION['theme'], PROJECT.'customer/dash/profile-settings') ?>" class="btn btn-primary">
                        <!-- Download SVG icon from http://tabler-icons.io/i/check -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M10.325 4.317c.426 -1.756 2.924 -1.756 3.35 0a1.724 1.724 0 0 0 2.573 1.066c1.543 -.94 3.31 .826 2.37 2.37a1.724 1.724 0 0 0 1.065 2.572c1.756 .426 1.756 2.924 0 3.35a1.724 1.724 0 0 0 -1.066 2.573c.94 1.543 -.826 3.31 -2.37 2.37a1.724 1.724 0 0 0 -2.572 1.065c-.426 1.756 -2.924 1.756 -3.35 0a1.724 1.724 0 0 0 -2.573 -1.066c-1.543 .94 -3.31 -.826 -2.37 -2.37a1.724 1.724 0 0 0 -1.065 -2.572c-1.756 -.426 -1.756 -2.924 0 -3.35a1.724 1.724 0 0 0 1.066 -2.573c-.94 -1.543 .826 -3.31 2.37 -2.37c1 .608 2.296 .07 2.572 -1.065z" />
                            <path d="M12 12m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0" />
                        </svg>
                        Paramètres et Autres détails
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Page body -->
<div class="page-body">
    <div class="container-xl">
        <div class="row g-3">
            <div class="col">
                <ul class="timeline">
                    <li class="timeline-event">
                        <div class="timeline-event-icon bg-twitter-lt">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M4 5m0 2a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2z"></path>
                                <path d="M16 3l0 4"></path>
                                <path d="M8 3l0 4"></path>
                                <path d="M4 11l16 0"></path>
                                <path d="M10 16l4 0"></path>
                                <path d="M12 14l0 4"></path>
                            </svg>
                        </div>
                        <div class="card timeline-event-card">
                            <div class="card-body">
                                <h4>Date de création</h4>
                                <p class="text-muted">You’re getting more and more followers, keep it up!</p>
                            </div>
                        </div>
                    </li>
                    <li class="timeline-event">
                        <div class="timeline-event-icon bg-twitter-lt">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M8 10v-7l-2 2"></path>
                                <path d="M6 16a2 2 0 1 1 4 0c0 .591 -.601 1.46 -1 2l-3 3h4"></path>
                                <path d="M15 14a2 2 0 1 0 2 -2a2 2 0 1 0 -2 -2"></path>
                                <path d="M6.5 10h3"></path>
                            </svg>
                        </div>
                        <div class="card timeline-event-card">
                            <div class="card-body">
                                <h4>Nombre de colis créé à ce jour</h4>
                                <p class="text-muted">Congratulations!</p>
                            </div>
                        </div>
                    </li>
                    <li class="timeline-event">
                        <div class="timeline-event-icon"><!-- Download SVG icon from http://tabler-icons.io/i/check -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M5 12l5 5l10 -10" />
                            </svg>
                        </div>
                        <div class="card timeline-event-card">
                            <div class="card-body">
                                <div class="text-muted float-end">1 day ago</div>
                                <h4>Database backup completed!</h4>
                                <p class="text-muted">Download the <a href="#">latest backup</a>.</p>
                            </div>
                        </div>
                    </li>
                    <li class="timeline-event">
                        <div class="timeline-event-icon bg-facebook-lt"><!-- Download SVG icon from http://tabler-icons.io/i/brand-facebook -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M7 10v4h3v7h4v-7h3l1 -4h-4v-2a1 1 0 0 1 1 -1h3v-4h-3a5 5 0 0 0 -5 5v2h-3" />
                            </svg>
                        </div>
                        <div class="card timeline-event-card">
                            <div class="card-body">
                                <div class="text-muted float-end">1 day ago</div>
                                <h4>+290 Page Likes</h4>
                                <p class="text-muted">This is great, keep it up!</p>
                            </div>
                        </div>
                    </li>
                    <li class="timeline-event">
                        <div class="timeline-event-icon"><!-- Download SVG icon from http://tabler-icons.io/i/user-plus -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M9 7m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" />
                                <path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
                                <path d="M16 11h6m-3 -3v6" />
                            </svg>
                        </div>
                        <div class="card timeline-event-card">
                            <div class="card-body">
                                <div class="text-muted float-end">2 days ago</div>
                                <h4>+3 Friend Requests</h4>
                                <div class="avatar-list mt-3">
                                    <span class="avatar" style="background-image: url(./static/avatars/000m.jpg)">
                                        <span class="badge bg-success"></span></span>
                                    <span class="avatar">
                                        <span class="badge bg-success"></span>JL</span>
                                    <span class="avatar" style="background-image: url(./static/avatars/002m.jpg)">
                                        <span class="badge bg-success"></span></span>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="timeline-event">
                        <div class="timeline-event-icon"><!-- Download SVG icon from http://tabler-icons.io/i/photo -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M15 8l.01 0" />
                                <path d="M4 4m0 3a3 3 0 0 1 3 -3h10a3 3 0 0 1 3 3v10a3 3 0 0 1 -3 3h-10a3 3 0 0 1 -3 -3z" />
                                <path d="M4 15l4 -4a3 5 0 0 1 3 0l5 5" />
                                <path d="M14 14l1 -1a3 5 0 0 1 3 0l2 2" />
                            </svg>
                        </div>
                        <div class="card timeline-event-card">
                            <div class="card-body">
                                <div class="text-muted float-end">3 days ago</div>
                                <h4>+2 New photos</h4>
                                <div class="mt-3">
                                    <div class="row g-2">
                                        <div class="col-6">
                                            <div class="media media-2x1 rounded">
                                                <a class="media-content" style="background-image: url(./static/photos/blue-sofa-with-pillows-in-a-designer-living-room-interior.jpg)"></a>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="media media-2x1 rounded">
                                                <a class="media-content" style="background-image: url(./static/photos/home-office-desk-with-macbook-iphone-calendar-watch-and-organizer.jpg)"></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="timeline-event">
                        <div class="timeline-event-icon"><!-- Download SVG icon from http://tabler-icons.io/i/settings -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M10.325 4.317c.426 -1.756 2.924 -1.756 3.35 0a1.724 1.724 0 0 0 2.573 1.066c1.543 -.94 3.31 .826 2.37 2.37a1.724 1.724 0 0 0 1.065 2.572c1.756 .426 1.756 2.924 0 3.35a1.724 1.724 0 0 0 -1.066 2.573c.94 1.543 -.826 3.31 -2.37 2.37a1.724 1.724 0 0 0 -2.572 1.065c-.426 1.756 -2.924 1.756 -3.35 0a1.724 1.724 0 0 0 -2.573 -1.066c-1.543 .94 -3.31 -.826 -2.37 -2.37a1.724 1.724 0 0 0 -1.065 -2.572c-1.756 -.426 -1.756 -2.924 0 -3.35a1.724 1.724 0 0 0 1.066 -2.573c-.94 -1.543 .826 -3.31 2.37 -2.37c1 .608 2.296 .07 2.572 -1.065z" />
                                <path d="M12 12m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0" />
                            </svg>
                        </div>
                        <div class="card timeline-event-card">
                            <div class="card-body">
                                <div class="text-muted float-end">2 weeks ago</div>
                                <h4>System updated to v2.02</h4>
                                <p class="text-muted">Check the complete changelog at the <a href="#">activity
                                        page</a>.</p>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
            
        </div>
    </div>
</div>

<?php include 'app/common/agents/2ndpart.php' ?>