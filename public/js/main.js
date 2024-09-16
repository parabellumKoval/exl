// var ratingList = $(".rating").find(".stars-container");
// ratingList.each(function () {
//   var id = "#" + $(this).attr("id");
//   var score = $(this).attr("score");
//   var intScore = Math.floor(score);

//   $(id + " #star" + intScore).addClass("selected");

//   $(id + " .star").on("click", function () {
//     $(id + " .star").removeClass("selected");
//     $(this).addClass("selected");
//     var starScore = $(this).attr("star-score");
//     rateSet(id, starScore);
//   });
// });

// function rateSet(id, score) {
//   $("#rateType").val("set");
//   $("#rateID").val(id);
//   $("#rateScore").val(score);
//   $("#rateSubmit").click();
// }

// function pageUp() {
//   window.scrollTo({ top: 0, behavior: "smooth" });
// }
const readMoreBlock = document.createElement("div");
readMoreBlock.classList.add("read-more");
readMoreBlock.textContent = "MORE";

const commentsBlock = document.querySelector(".comments-items");
const comments = document.querySelectorAll(".comments-item");
if (comments.length > 3) {
  commentsBlock.classList.add("comments-hide");
  commentsBlock.append(readMoreBlock);

  readMoreBlock.addEventListener("click", () => {
    commentsBlock.classList.toggle("comments-hide");
    if (!commentsBlock.classList.contains("comments-hide")) {
      readMoreBlock.textContent = "HIDE";
    } else {
      readMoreBlock.textContent = "MORE";
    }
  });
}
const mobileMenuBlock = document.querySelector(".header-mobile-menu");

const mobileMenu = document.querySelector(".header-mobile-btn");
mobileMenu.addEventListener("click", () => {
  mobileMenuBlock.classList.add("header-mobile-menu-show");
});
const mobileCloseBtn = document.querySelector(".header-mobile-menu-close");
mobileCloseBtn.addEventListener("click", () => {
  mobileMenuBlock.classList.remove("header-mobile-menu-show");
});
const commentAnswerForm = document.querySelector(".comments-answer-form");
document.querySelectorAll(".comments-item").forEach((commentEl) => {
  document.querySelectorAll(".comments-answer-form").forEach((answerFormEl) => {
    const commentItemId = commentEl.getAttribute("data-comment-id");
    const answerFormId = answerFormEl.getAttribute("data-form-id");

    if (commentItemId === answerFormId) {
      document
        .getElementById("comment-btn-" + commentItemId)
        .addEventListener("click", () => {
          answerFormEl.classList.toggle("form-hide");
        });
    }
  });
});

$(document).ready(function () {
  $(".youtube-items").slick({
    slidesToShow: 1,
    slidesToScroll: 1,
    arrows: true,
    dots: false,
    speed: 300,
    infinite: true,
    autoplaySpeed: 3000,
    autoplay: false,
    responsive: [
      {
        breakpoint: 991,
        settings: {
          slidesToShow: 2,
        },
      },
      {
        breakpoint: 767,
        settings: {
          slidesToShow: 1,
        },
      },
      {
        breakpoint: 378,
        settings: {
          slidesToShow: 1,
        },
      },
    ],
  });
});

$(document).ready(function () {
  $(".card-sm-items").slick({
    slidesToShow: 7,
    slidesToScroll: 1,
    arrows: true,
    dots: false,
    speed: 300,
    infinite: true,
    autoplaySpeed: 5000,
    autoplay: false,
    centerMode: true,
    variableWidth: true,
    adaptiveHeight: true,
    responsive: [
      {
        breakpoint: 991,
        settings: {
          slidesToShow: 2,
        },
      },
      {
        breakpoint: 767,
        settings: {
          slidesToShow: 1,
        },
      },
      {
        breakpoint: 378,
        settings: {
          slidesToShow: 1,
        },
      },
    ],
  });
});

$(document).ready(function () {
  $(".card-big-items").slick({
    slidesToShow: 3,
    slidesToScroll: 1,
    arrows: true,
    dots: false,
    speed: 300,
    infinite: true,
    autoplaySpeed: 3000,
    autoplay: false,
    centerMode: false,
    variableWidth: true,
    adaptiveHeight: false,
    responsive: [
      {
        breakpoint: 991,
        settings: {
          slidesToShow: 1,
        },
      },
      {
        breakpoint: 767,
        settings: {
          slidesToShow: 1,
        },
      },
      {
        breakpoint: 378,
        settings: {
          slidesToShow: 1,
        },
      },
    ],
  });
});

$(document).ready(function () {
  $(".card-md-items").slick({
    slidesToShow: 4,
    slidesToScroll: 1,
    arrows: true,
    dots: false,
    speed: 300,
    infinite: true,
    autoplaySpeed: 2000,
    autoplay: false,
    centerMode: true,
    variableWidth: true,
    adaptiveHeight: true,
    responsive: [
      {
        breakpoint: 991,
        settings: {
          slidesToShow: 3,
        },
      },
      {
        breakpoint: 767,
        settings: {
          slidesToShow: 1,
        },
      },
    ],
  });
});
