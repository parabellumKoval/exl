(function()
{	
	this.ReviewsBase = function()
	{
		let defaults = {};
		
		this.elements = [];
		this.settings = (arguments[0] && typeof arguments[0] === 'object') ? extendDefaults(defaults,arguments[0]) : defaults;
		
		this.init();
	}
	
	
	// INIT
	ReviewsBase.prototype.init = function()
	{
		build.call(this);
	}
	
	
	// UPDATE
	ReviewsBase.prototype.update = function(element)
	{}
	
	
	// BUILD
	function build(element)
	{
    // Reply button handler
    // toggle reply form
    setReplyHandler.call(element)
    
    // Show more reviews handler
    // toggle classses
    setShowMoreHandler.call(element)
    
    // Set rating (stars) handler
    //
    setRatingHandler.call(element)
	}


  //
  // RATING
  //  
  function setRatingHandler(element) {
    const stars = document.querySelectorAll("[data-item=formStars] [data-item=formStar]")

    stars.forEach((star) => {
      star.addEventListener("click", (item) => {
        const targetHtml = item.target
        const value = targetHtml.getAttribute('data-item-value')
        const wrapper = targetHtml.parentElement
        
        setClassToRating(value)
        setValueToForm(value, targetHtml)
      })
    })
  }

  //
  // VALUE TO FORM
  // 
  function setValueToForm(value, element) {
    const form = element.closest('[data-item=reviewForm]')
    const inputHidden = form.querySelector('[data-item=hiddenRating]')

    inputHidden.value = value
  }

  //
  // CLASS TO RATING
  //  
  function setClassToRating(value) {
    // clear all stars from active class
    document.querySelectorAll("[data-item=formStar]").forEach((star) => {star.classList.remove('active')})

    // set current score value
    for(let i = 1; i <= value; i++) {
      const star = document.querySelector("[data-item=formStar]:nth-of-type(" + i + ")")
      star.classList.add('active')
    }
  }

  //
  // SHOW MORE
  //  
  function setShowMoreHandler(element) {
    const btn = document.querySelector("[data-action=showMoreReviews]")

    if(!btn) {
      return
    }

    const wrapper = btn.closest('div[data-item=reviewsBlock]')

    btn.addEventListener("click", () => {
      // CLASS HIDE
      wrapper.classList.toggle('comments-hide')
      btn.querySelector('[data-item=showMoreHide]').classList.toggle('hide')
      btn.querySelector('[data-item=showMoreShow]').classList.toggle('hide')
    })
  }


  //
  // REPLY
  //  
	function setReplyHandler(element) {
    document.querySelectorAll("button[data-action=openReply]").forEach((item) => {

      const itemWrapper = item.closest('div[data-comment-id]')
      const commentId = itemWrapper.getAttribute('data-comment-id')

      const replyForm = document.querySelector('.comments-form[data-form-id="' + commentId + '"]')

      item.addEventListener("click", () => {
         // CLASS HIDE
        replyForm.classList.toggle('form-hide')
      });
    })
  }
	
	
	function extendDefaults(defaults,properties)
	{
		Object.keys(properties).forEach(property => {
			if(properties.hasOwnProperty(property))
			{
				defaults[property] = properties[property];
			}
		});
		return defaults;
	}
}());