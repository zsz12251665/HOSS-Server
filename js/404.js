// Add the 4s and 0s to the background
for (let i = 0; i < 40; ++i)
{
	document.querySelector('body').innerHTML += '<span style="animation: ' + Math.floor(Math.random() * 20 + 20) + 's ' + animationFunction() + ' infinite;filter: blur(' + (0.04 * i + 0.02) + 'px);font-size: ' + Math.floor(Math.random() * 20 + 10) + 'px;left: ' + (Math.random() * 100) + '%;top: ' + (Math.random() * 100) + '%;">4</span>';
	document.querySelector('body').innerHTML += '<span style="animation: ' + Math.floor(Math.random() * 20 + 20) + 's ' + animationFunction() + ' infinite;filter: blur(' + (0.04 * i + 0.04) + 'px);font-size: ' + Math.floor(Math.random() * 20 + 10) + 'px;left: ' + (Math.random() * 100) + '%;top: ' + (Math.random() * 100) + '%;">0</span>';
}
// The animation function generator
function animationFunction()
{
	switch (Math.floor(Math.random() * 4))
	{
		case 0:
			return 'float';
		case 1:
			return 'float2';
		case 2:
			return 'floatReverse';
		default:
			return 'floatReverse2';
	}
}
