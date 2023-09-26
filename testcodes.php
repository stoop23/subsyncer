<div id="test">
									<h1>dqsdqs</h1>
									<h1>gfdgd</h1>
									<h1>yeyere</h1>
								</div>
								<style>
									#test h1 {
										position: absolute;
										visibility: hidden;
									}
									.abc {
										visibility: visible!important;
									}
									</style>
								<script>
									
									
									var ancestor = document.getElementById('test'),
									descendents = ancestor.getElementsByTagName('*');
									console.log(descendents);
									var i = 0;
									var myInterval = setInterval(function() {
										Object.keys(descendents).forEach(function (el){
											descendents[el].classList.remove("abc");
											//console.log(descendents[key]);
										});
										console.log(i);
										console.log(descendents[i].innerHTML);
										descendents[i].classList.add("abc");
										++i;
										if(i == 3) {
											i = 0;
										}
										
									}, 1000);

/*
									var i, e, d;
									for (i = 0; i < descendents.length; ++i) {


										(function (i) {
											setTimeout(function () {
																						e = descendents[i];
										e.innerHTML;
										console.log(e);
												console.log(e.innerHTML);
											}, 1000 * i);
										})(i);
									}
									*/

								</script>