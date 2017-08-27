<?php 
// Function global
use Jenssegers\Agent\Agent;

function getDevice2() {
    $agent = new Agent();
    if($agent->isTablet()) {
        return TABLET;
    } else if($agent->isMobile()) {
        return MOBILE;
    } else {
        return PC;
    }
}

function trimRequest($request) {
    $input = $request->all();
    // use a closure here because array_walk_recursive passes
    // two params to the callback, the item + the key. If you were to just
    // call trim directly, you could end up inadvertently trimming things off
    // your array values, and pulling your hair out to figure out why.
    array_walk_recursive($input, static function(&$in) {
        $in = trim($in);
    });
    $request->merge($input);
}
// End function

// device
define('MOBILE', 1);
define('PC', 2);
define('TABLET', 3);
// cache: 1: cache, 2: non cache
define('CACHE', 1);
// lang
define('VI', 'vi');
define('EN', 'en');
// admin role id
define('ADMIN', 1);
define('EDITOR', 2);
// user role id
define('USERNORMAL', 1);
// trang thai
define('ACTIVE', 1);
define('INACTIVE', 2);
//loai post
define('POST_TV', 1);
define('POST_MOVIE', 2);
define('POST_OVA', 3);
define('POST_ONA', 4);
// menu top nam ngang
define('MENUTYPE1', 1);
// menu side
define('MENUTYPE2', 2);
// menu bottom
define('MENUTYPE3', 3);
//  menu mobile
define('MENUTYPE4', 4);
// pagination
define('PAGINATION', 30);
define('PAGINATE', 30);
define('PAGINATE_LATEST', 30);
define('PAGINATE_HOT', 15);
define('PAGINATE_RELATED', 6);
define('PAGINATE_BOX', 36);
// SLIDER
define('SLIDER1', 1); // slider on top home page
define('SLIDER2', 2); // slider on bottom page
define('SLIDER3', 3); //  
// replace string
define('CONTACTFORM', '/%ContactForm%/');
// trang thai crawler
define('CRAW_POST', 1);
define('CRAW_CATEGORY', 2);
// image crawler
define('CRAW_POST_IMAGE', 1);
define('CRAW_CATEGORY_IMAGE', 2);
// crawler lay tieu de tu trang category hay tu trang chi tiet post
define('CRAW_TITLE_POST', 1);
define('CRAW_TITLE_CATEGORY', 2);
// display
define('DISPLAY_1', 1); // Hình ảnh kèm tiêu đề
define('DISPLAY_2', 2); // Chỉ hiển thị tiêu đề
// responsive filemanager
define('AKEY', 'db0ac2431a2e87c54852dbb0e7b9ed3d');
// slug type
define('SLUGTYPE1', 1); // lay slug theo tieu de bai viet lay duoc
define('SLUGTYPE2', 2); // lay slug theo slug cua link nguon bai viet
define('SLUGTYPE3', 3); // lay slug theo danh sach slug tuong ung voi danh sach link nguon bai viet
// title type
define('TITLETYPE1', 1); // Lấy tiêu đề bài tự động theo mẫu thẻ lấy tiêu đề
define('TITLETYPE2', 2); // Lấy tiêu đề tự động theo danh sách slug tương ứng ds link nguồn
define('TITLETYPE3', 3); // Lấy tiêu đề theo danh sách tiêu đề tương ứng ds link nguồn
// co anh toi thieu co the tao watermark
define('WATERMARK_MINWIDTH', 160);
define('WATERMARK_MINHEIGHT', 150);
// thumbnail image size
define('THUMB_DIMENSIONS', '225x300 / 80x80 / 45x60');
define('IMAGE_WIDTH', 225);
define('IMAGE_HEIGHT', 300);
define('IMAGE_WIDTH_2', 80);
define('IMAGE_HEIGHT_2', 80);
define('IMAGE_WIDTH_3', 45);
define('IMAGE_HEIGHT_3', 60);
define('SLIDE_HEADER_DIMENSIONS', '775x380');
define('SLIDE_FOOTER_DIMENSIONS', '200x120');
// SLUG
define('SLUG_SEASON_WINTER', 'dong');
define('SLUG_SEASON_SPRING', 'xuan');
define('SLUG_SEASON_SUMMER', 'ha');
define('SLUG_SEASON_AUTUMN', 'thu');

define('SLUG_NATION_JAPAN', 'nhat-ban');
define('SLUG_NATION_USA', 'au-my');
define('SLUG_NATION_KOREAN', 'han-quoc');
define('SLUG_NATION_CHINA', 'trung-quoc');
define('SLUG_NATION_VIETNAM', 'viet-nam');
define('SLUG_NATION_OTHER', 'nuoc-khac');
define('SLUG_POST_KIND_FULL', 'da-hoan-thanh');
define('SLUG_POST_KIND_UPDATING', 'con-tiep-tuc');
// cookie name
define('COOKIE_NAME', 'clients');
// watermark base64 code
define('WATERMARK_BASE64', 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAALAAAAAcCAYAAADBaTXLAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAyJpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuMy1jMDExIDY2LjE0NTY2MSwgMjAxMi8wMi8wNi0xNDo1NjoyNyAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wTU09Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9tbS8iIHhtbG5zOnN0UmVmPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvc1R5cGUvUmVzb3VyY2VSZWYjIiB4bWxuczp4bXA9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC8iIHhtcE1NOkRvY3VtZW50SUQ9InhtcC5kaWQ6MzdFREIxODc3N0FDMTFFN0FBREU5MjVDOTc5QkJCRDgiIHhtcE1NOkluc3RhbmNlSUQ9InhtcC5paWQ6MzdFREIxODY3N0FDMTFFN0FBREU5MjVDOTc5QkJCRDgiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIENTNiAoV2luZG93cykiPiA8eG1wTU06RGVyaXZlZEZyb20gc3RSZWY6aW5zdGFuY2VJRD0ieG1wLmlpZDpBRkQwNTFEMzVFMjgxMUU3QTRBRkE0OUFFQjYxQTVBRCIgc3RSZWY6ZG9jdW1lbnRJRD0ieG1wLmRpZDpBRkQwNTFENDVFMjgxMUU3QTRBRkE0OUFFQjYxQTVBRCIvPiA8L3JkZjpEZXNjcmlwdGlvbj4gPC9yZGY6UkRGPiA8L3g6eG1wbWV0YT4gPD94cGFja2V0IGVuZD0iciI/Psz+T3IAAABRSURBVHja7NIBDQAACMMwwL/nowPSSljWSQquGgkwMBgYDIyBwcBgYDAwBgYDg4HBwBgYDAwGxsBgYDAwGBgDg4HBwGBgDAwGBgODgfliBRgAMN8DNVVEe+EAAAAASUVORK5CYII=');
// RECAPTCHA (nmd2711@gmail.com)
// has script submit form
define('RECAPTCHASITEKEY', '6LfA9isUAAAAAPlYNcK1HGTzvAvCqXY6ALYNjQxS');
define('RECAPTCHASECRETKEY', '6LfA9isUAAAAALmEpMChTfpxsR6ALba9hT4v_wY4');
// add:
// <div class="g-recaptcha" data-sitekey="6Lf1ACwUAAAAAEFI_NOzNNusy35BnI1-O_TuHsq_"></div>
// remove script submit form
define('RECAPTCHAV2SITEKEY', '6Lf1ACwUAAAAAEFI_NOzNNusy35BnI1-O_TuHsq_');
define('RECAPTCHAV2SECRETKEY', '6Lf1ACwUAAAAANuaum0m2ciCooT-LLhyVypWsPwR');
// server
define('SERVER1', 'Unknow');
define('SERVER2', 'Google Drive');
define('SERVER3', 'Google Photo');
define('SERVER4', 'Youtube');
define('SERVER5', 'Openload');
define('SERVER6', 'Streamango');
define('SERVER7', 'Vimeo');
define('SERVER8', 'Unknow');
define('SERVER9', 'Unknow');
