// DOM elements
$characterCount = $('#char-count')
$composeEditor  = $('#compose-editor')
$placeholder    = $('#placeholder')
$submitButton   = $('#submit-button')

// Set and display character limit
window.tweetTotal = 140

$characterCount.text(tweetTotal)

// Handle placeholder text display
$composeEditor.on 'click', (event)->
  $placeholder.hide()
  $(event.currentTarget).focus()
  
$composeEditor.on 'blur', (event)->
  if $(event.currentTarget).text().length == 0  
    $placeholder.show()
    $(event.currentTarget).removeClass 'focus'
  else
    if $(event.currentTarget).hasClass 'focus'
      $(event.currentTarget).removeClass 'focus'
    else
      $(event.currentTarget).addClass 'focus'
    
$placeholder.on 'click', (event)->
  $(event.currentTarget).hide()
  $composeEditor.focus()

// Events tied to activity in textarea
$composeEditor.on 'keyup', (event)->
  tweetCount = $(event.currentTarget).text().length

  updateCharCount(tweetCount)
  
  // Disable submit based on char count
  if tweetCount >= 140 || tweetCount == 0
    $submitButton.attr 'disabled', 'disabled'
  else
    $submitButton.removeAttr 'disabled'

// Update Tweet Character Limit Count
updateCharCount = (tweetCount) ->
  remainingChars = window.tweetTotal - tweetCount
    
  // Highlight tweet count with warning if less than 20 characters left
  if remainingChars <= 20
    $characterCount.addClass 'warning'
  else
    $characterCount.removeClass 'warning'
  
  $characterCount.text remainingChars