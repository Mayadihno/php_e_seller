<style>
    .blog_bg_1 {
        background-image: url('https://t4.ftcdn.net/jpg/06/72/94/05/360_F_672940537_gIf5WUgS5galHNM46z6p03rI1B5TwRKQ.jpg');
        background-size: cover;
        background-position: center center;
        background-repeat: no-repeat;
        height: 50vh;
        position: relative;
        border-radius: 20px;
    }

    .blog_bg_2 {
        background-image: url('https://v.etsystatic.com/video/upload/q_auto/Animated_Neon_Yellow_Webcam_Overlay_zni2sn.jpg');
        background-size: cover;
        background-position: center center;
        background-repeat: no-repeat;
        height: 50vh;
        position: relative;
        border-radius: 20px;
    }
</style>
<div class="my-5 container-fluid px-5" style="padding-top: 50px;">
    <div class="d-flex justify-content-between align-items-center gap-3">
        <div class="blog_bg_1 w-100">
            <div class="position-absolute top-0 start-0 w-100 h-100 bg-dark opacity-50" style=" border-radius: 20px;"></div>
            <div class="position-absolute top-50 container ms-3 start-50 translate-middle text-white">
                <h3 class="fs-5">Turn Down</h3>
                <h2 class="yel fs-4 fw-bold">The Chaos,</h2>
                <hr class="w-50">
                <h4 class="fs-5">Turn Up The productivity</h4>
                <button class="button mt-3 fw-semibold">Shop Now</button>
            </div>
        </div>
        <div class="blog_bg_2 w-100">
            <div class="position-absolute top-0 start-0 w-100 h-100 bg-dark opacity-50" style=" border-radius: 20px;"></div>
            <div class="position-absolute top-50 container ms-3 start-50 translate-middle text-white">
                <h2 class="yel fs-4 fw-bold">Gaming,</h2>
                <h3 class="fs-5">on the go</h3>
                <hr class="w-50">
                <h4 class="fs-5">From Boarding gates to Battlesfields</h4>
                <button class="button mt-3 fw-semibold">Shop Now</button>
            </div>
        </div>
    </div>
    <div class="mt-5">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="fw-bold fs-2 ms-4 mb-4">Blogs & Events</h2>
            <div class="d-flex align-items-center me-5">
                <a href="" class="text-primary">
                    <span>View all</span>
                    <i class="fa-solid fa-greater-than" style="font-size: 14px;"></i>
                </a>
            </div>
        </div>
        <?php
        $blogs = json_decode(file_get_contents(__DIR__ . '/../../data/blog.json'));
        ?>
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-4">
            <?php foreach ($blogs as $blog): ?>
                <div class="col">
                    <div class="card border-0 shadow h-100" style="border-top-right-radius: 11px; border-top-left-radius: 11px; background-color: #FAFAFA;">
                        <div class="card-img-top img-fluid">
                            <img src="<?= $blog->image ?>"
                                class="w-100"
                                style="height: 300px; border-top-right-radius: 10px; border-top-left-radius: 10px;"
                                alt="<?= $blog->title ?>">
                        </div>
                        <div class="card-body">
                            <div class="d-flex align-content-center py-2">
                                <i class="fa-solid fa-calendar-days mt-1"></i>
                                <span class="text-muted ms-2"><?= $blog->date ?></span>
                            </div>
                            <h5 class="fw-semibold fs-4 mb-2"><?= $blog->title ?></h5>
                            <p class="fw-normal text-muted fs-6 mb-1"><?= $blog->desc ?></p>
                            <p class="fw-medium fs-6 text-decoration-underline" style="cursor: pointer">Read more</p>
                        </div>
                    </div>
                </div>
            <?php endforeach ?>
        </div>
    </div>
</div>