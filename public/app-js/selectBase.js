(function()
{	
	this.SelectBase = function()
	{
		let defaults = {};
		
		this.elements = [];
		this.settings = (arguments[0] && typeof arguments[0] === 'object') ? extendDefaults(defaults,arguments[0]) : defaults;
		
		this.init();
	}
	
	
	// INIT
	SelectBase.prototype.init = function()
	{
		build.call(this);
	}
	
	
	// UPDATE
	SelectBase.prototype.update = function(element)
	{}
	
	
	// BUILD
	function build(element)
	{
    // Reply button handler
    // toggle reply form
    setSelectHandler.call(element)
	}

  //
  // Custom select
  //
  function setSelectHandler(element) {
    document.querySelectorAll("[data-item=baseSelect]").forEach((select) => {
      select.addEventListener("click", (event) => {
        const item = event.target
        const select = item.closest('[data-item=baseSelect]')
        select.classList.toggle('active')
      })

      select.querySelectorAll("[data-item=baseSelectItem]").forEach((option) => {
        option.addEventListener("click", (event) => {
          const item = event.target
          const itemKey = item.getAttribute('data-value')
          const itemString = item.innerText

          const select = item.closest('[data-item=baseSelect]')
          const currentValue = select.querySelector('[data-item=baseSelectValue]')

          currentValue.innerText = itemString
          
          console.log(item, itemKey, select)
          sendFormHandler(itemKey, select)
        })
      })
    })
  }

  //
  // Send form (reload page) if exist
  //
  function sendFormHandler(newValue, selectElement) {
    const formId = selectElement.getAttribute('data-form-id')

    if(!formId) {
      return
    }

    const form = document.getElementById(formId)
    const hiddenInput = form.querySelector('input[name=reviews_sort]')

    hiddenInput.value = newValue

    form.submit()
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