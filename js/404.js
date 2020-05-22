// The animation function generator
function animation()
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
// Add the 4s and 0s to the background
for (let i = 1; i <= 80; ++i)
{
	document.querySelector('body').innerHTML += '<span style="animation: ' + Math.floor(Math.random() * 20 + 20) + 's ' + animation() + ' infinite;filter: blur(' + 0.02 * i + 'px);font-size: ' + Math.floor(Math.random() * 20 + 10) + 'px;left: ' + Math.random() * 100 + '%;top: ' + Math.random() * 100 + '%;">' + i % 2 * 4 + '</span>';
}
