function findGetParameter(parameterName) {
    var result = null,
        tmp = [];
    location.search
        .substr(1)
        .split("&")
        .forEach(function (item) {
          tmp = item.split("=");
          if (tmp[0] === parameterName) result = decodeURIComponent(tmp[1]);
        });
    return result;
}

function loadPage(page) {
  $.ajax({
    method: "POST",
    url: page,
    data: {}
  })

  .done(function(data) {
    $(".body").append(page + ": " + data);
  })

  .fail(function(data) {
    $(".body").append("AJAX Request to page " + page + " failed: <br>");
    $(".body").append("Data: <br>" + data);
  });
}
