
  function time_ago(timestamp) {
    let postDate = new Date(timestamp);
    let currentTime = new Date();


    // To calculate the time difference of two dates
    let time_diff = currentTime.getTime() - postDate.getTime();
    let seconds = time_diff / 1000;
    let minutes = 0;
    let hours = 0;
    let days = 0;
    let weeks = 0;
    let months = 0;
    let years = 0;

    minutes = Math.round(seconds / 60); // value 60 is seconds  
    hours = Math.round(seconds / 3600); //value 3600 is 60 minutes * 60 sec  
    days = Math.round(seconds / 86400); //86400 = 24 * 60 * 60;  
    weeks = Math.round(seconds / 604800); // 7*24*60*60;  
    months = Math.round(seconds / 2629440); //((365+365+365+365+366)/5/12)*24*60*60  
    years = Math.round(seconds / 31553280);


    // To calculate the no. of days between two dates
    // let Difference_In_Days = Difference_In_Time / (1000 * 3600 * 24)

    if (seconds <= 60) {
      return "Just Now";
    } else if (minutes <= 60) {
      if (minutes == 1) {
        return "one minute ago";
      } else {
        return minutes + " minutes ago";
      }
    } else if (hours <= 24) {
      if (hours == 1) {
        return "an hour ago";
      } else {
        return hours + " hrs ago";
      }
    } else if (days <= 7) {
      if (days == 1) {
        return "yesterday";
      } else {
        return days + " days ago";
      }
    } else if (weeks <= 4.3) //4.3 == 52/12  
    {
      if (weeks == 1) {
        return "a week ago";
      } else {
        return weeks + " weeks ago";
      }
    } else if (months <= 12) {
      if (months == 1) {
        return "a month ago";
      } else {
        return months + " months ago";
      }
    } else {
      if (years == 1) {
        return "one year ago";
      } else {
        return years + " years ago";
      }
    }
  }