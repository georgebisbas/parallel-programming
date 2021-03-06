<!DOCTYPE html> 
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Travelling Salesman Problem</title>
        <link rel="stylesheet" href="css/style.css" />
        <link rel="stylesheet" href="css/demo_table.css" />
        <link rel="stylesheet" href="css/demo_page.css" />
    </head>
    <body>
        <div class="modals" <?php
            if( $_COOKIE && @$_COOKIE[ 'run' ] == 1 ){
                ?> style="display: none"<?php
            }
        ?>>
            <div class="modal">
                <p>
                    This is an academic experiment, which aims to aproximate the solution of a TSP for <a href="ca4663.tsp">4663 cities</a>. To do so, 
                    we use the 3-opt algorithm, and a grid of computers, over the web. The members of this grid are simple users, like you, 
                    who contribute their computing power to help this experiment. In order to participate, just click YES. Be aware that if 
                    you agree, your cpu will be used to do the necessary calculations. Please, click NO if you are using a smartphone, or a 
                    laptop with no power supply.
                </p>
                <p>
                    During the execution of the algorithm, a number of threads will be used. You can select that number above. For best results 
                    use one thread per core of your cpu. We use a technology called Web Workers, which helps us run demanding algorithms without
                    making your browser unresponsive. Though, you may notice some inconsistency, if you use more threads than
                    your cpu cores. In that case, just decrease the number of threads from the control panel. Keep in mind that the number of threads 
                    may need up to some minutes to change. You can cancel the process at any time by navigating away. This 
                    process is COMPLETELY HARMLESS for your computer: No hardware or software failure can be caused. Your computer will start 
                    making noise, as the cpu fan wil increase it's speed to keep the cpu in low tempetarure. This is an expected behaviour, and 
                    not a problem. We will not access or use any personal information of yours.
                </p>
                <p> Number of Threads: 
                    <select>
                        <option value="1">1 thread: Low</option>
                        <option value="2">2 threads: Medium</option>
                        <option value="4" selected="">4 threads: High</option>
                        <option value="7">7 threads</option>
                        <option value="8">8 threads: Maximum</option>
                    </select>
                </p>
                <button class="yes">Yes, use my computer.</button>
                <button class="No">No, I have limited computation power or battery.</button>
                <p class="note">
                    We higly recomend using Google Chrome or Mozilla Firefox.<br />
                    Please do not open this page in multiple tabs from the same computer. We already use parallel technics which use many cpu
                    cores.
                </p>
            </div>
        </div>
        <ul class="log">
            <li>
                <span class="step"></span>
                    Control Panel 
                <select>
                    <option value="1">1 thread: Low</option>
                    <option value="2">2 threads: Medium</option>
                    <option value="4" selected="">4 threads: High</option>
                    <option value="7">7 threads</option>
                    <option value="8">8 threads: Maximum</option>
                </select>
                <a href="log" target="_blank">Statistics</a>
            </li>
            <li class="message"></li>
			<li><table class="users display"></table></li>
        </ul>
        <div class="container">
            <nav>
                <ul>
                    <li><a href="#problem">The Problem</a></li>
                    <li><a href="#exact">Exact Solutions</a></li>
                    <li><a href="#heuristic">Heuristic Solutions</a></li>
                    <li><a href="#ours">Our Implementation</a></li>
                </ul>

            </nav>
            <h1>Travelling Salesman Problem</h1>
            <h2 id="problem">The Problem</h2>
            <p>
                The Travelling Salesman Problem (TSP) is a deceptively simple
                combinatorial problem. It can be stated very simply: A salesman spends his time
                visiting N cities (or nodes) cyclically. In one tour he visits each city just once, and
                finishes up where he started. In what order should he visit them to minimize the
                distance traveled? TSP is applied in many different places such as warehousing,
                material handling and facility planning.
            </p>
            <h2 id="exact">Exact algorithms</h2>
            <h3>Brute Force</h3>
            <p>
                There are some algorithms that can solve the TSP deterministically. The most direct solution would be to try all permutations
                and see which leads to a minimum distance. This approach has a factorial complexity, O(n!), which makes it impossible to solve for 
                more than 20 cities. Within a lifetime, at least! 
            </p>
            <h3>Held-Karp</h3>
            <p>
                There is another algorithm, based on the dynamic programming technique, called 
                "Held-Karp algorithm", which solves the problem with a complexity of O(n<sup>2</sup>2<sup>n</sup>). This algorithm can solve up to
                25 cities, in a logical amount of time.
            </p>
            <p>
                According to Wikipedia, it is an open problem if there exists an exact algorithm for TSP that runs in time O(1.9999<sup>n</sup>).
                Some implementations based on linear programming, branch-and-bound or problem-specific, managed to solve up to 85.900 cities, using
                grids of computers.
            </p>
            <h2 id="heuristic">Heuristic and approximation algorithms</h2>
            <p>
                In some cases, the optimal solution is not mandatory, we only need a really good solution with a low complexity. The heuristic 
                algorithms of TSP can be classified as <strong>Construction Algorithms,</strong> <strong>Improvement Algorithms</strong> and 
                <strong>Hybrid Algorithms</strong>.
            </p><p>
                Construction algorithms are those in which the tour is constructed by including points in the tours, usually one at a time, 
                until a complete tour is developed. In improvement algorithms, a given initial solution is improved, if possible, by 
                transposing two or more points in the initial tour. With regard to improvement algorithms, two strategies are possible. 
                We may either consider all possible exchanges and choose the one that results in the greatest savings and continue this 
                process until no further reduction is possible, or as soon as a savings is available, we may make the exchange and examine 
                other possible exchanges and keep the process until we cannot improve the solutions any further. Hybrid Algorithms, as the one
                used in this implementation, are the algorithms that use a construction algorithm as a initial route for an improvement algorithm.
            </p>
            <h3>Construction algorithms: The Nearest Neighbor algorithm, or Greedy algorithm</h3>
            <p>
                One of the first and most easy-to-implement algorithms is the Nearest Neighbor algorithm (greedy algorithm), which can answer 
                the problem with relatively good results, in polynomial complexity, O(n<sup>2</sup>). This algorithm starts from a random city, 
                and finds the nearest non-visited city, until it has visited all cities.
            </p>
            <h3>Improvement Algorithms: The k-opt algorithm</h3>
            <p>
                The k-opt heuristic produces good results, which are improved over the time of execution: Given a set of cities, and a random tour,
                exchange k paths with new ones, so that the route remains closed. Repeat this exchange until the results are satisfying, or there 
                is not any exchange that can improve the tour. The complexity of this algorithm is O(n<sup>k</sup>). It is proven that, in order to 
                be sure that the results are optimal, you need to use all k-opt algorithms, with k from 2 to n. This leads to a complexity of
                O(n<sup>n</sup>) which is even slower than the brute-force solution. However, the solutions acquired by the 2-opt, 3-opt and 4-opt
                are usually really good.
            </p>
            <h3>The V-opt algorithm</h3>
            <p>
                The variable-opt method is related to, and generalization of the k-opt method. Whereas the k-opt methods remove a fixed number (k) of
                edges from the original tour, the variable-opt methods do not fix the size of the edge set to remove. Instead they grow the set as
                the search process continues. The best known method in this family is the <strong>Lin-Kernigham</strong> method, which is known as the
                most accurate heuristic algorithm, with optimal or near optimal solutions for most sets of cities. Lin-Kernigham uses the 
                V-opt algorithm, and decides while running which is the best value of V, in order to produce good results with low execution time. 
                Also, it uses a sophisticated system to validate the exchanges, and choose the ones that are most likely to produce a good result.
            <p>
            <h2 id="ours">Our Implementation</h2>
            <p>
                Our implementation of the problem uses the 3-opt algorithm along with parallel programming techniques. As mentioned above, the 
                3-opt algorithms’ complexity is O(n<sup>3</sup>) and in this case n=4663! So solving it with a linear method makes it extremely 
                difficult. That is why we divided the problem into smaller segments and ask YOU to solve them! Yeap, that’s right, you are part 
                of the solving process. 
            </p>
            <p>
                Now, before you start panicking, we are not going to ask you to pick up your pen and start solving equations -not that the Euclidean 
                distance is advanced mathematics, but still – instead we will let your pc do that! Here is how:
            </p>
            <p>
                A long long time ago, before you could even click on this page, the server initialized the route of all the Canadian cities using the 
                greedy algorithm (for more information on the greedy algorithm look above). Nice route, but still, not as good as a 3-opt. Now, the 
                algorithm requires to check every city and see if by making up to three changes in our route, the total distance reduces. This is 
                where you come in. Instead of checking all 4663 cities at once, we divide them into groups of eight. Then, every time someone 
                (i.e. you) enters our page we send them a group (8 cities). After they find the best three changes for these 8 
                cities (more on what your computer actually does later) they send us the results and we send them another group. This process 
                continues until all cities have been checked. Then the server finds the best of all these changes, applies it to the route and 
                the process starts all over again with the new route. The problem terminates when there are no more changes that can reduce the 
                total distance.
            </p>
            <p>
                Now you realize the more people (or rather PCs) come to our site and the longer they stay, the faster our algorithm will be complete. 
                And that is the first layer of our parallel programming technique!
            </p>
            <p>
                So, your computer checks 8 cities every time. This can be viewed in your console log. When it says “Running. This may take several minutes” 
                it means you are calculating the best change regarding these cities. When it says “Requesting new partition” it means you finished these 
                8 cities, you sent us the results and now you are receiving 8 more cities. 
            </p>
            <p>
                You may think that 8 cities is not such a big deal but think, the problem has been divided to problems of complexity O(n<sup>2</sup>) so 
                you have to check 8 cities with all the rest. That means ≈46602 * 8 repetitions! (in reality it is close to n<sup>2</sup> * 4 and less, due to the 
                cities we give you and their complexity but I won’t get into the math details now. For more information check our report that will be 
                posted soon). So you realize that your PC has a lot of work to do! For that reason we decided to divide your part of the problem to 
                even smaller ones. Since the multicore technology is such a hit these days, we aim to utilize all your CPU cores. This is achieved 
                using the Javascript Web Workers technology. What we do is create 4 workers (think of them as threads) and assign two cities to 
                each of them. So in reality you solve the problem of 8 cities in the time it takes to solve two (4 times faster!), provided of 
                course you have a 4-core CPU... (please please PLEASE have a multicore CPU!) And that is the second layer of our parallel programming 
                technique!
            </p>
            <p>
                So this is our implementation of the TSP problem, we hope you like it and we thank you for your help without which we could not solve 
                it. You are important to us and your every click counts. Besides, the whole is nothing but the sum of its parts! Thank you again and 
                we hope you will stay a little while longer on our site!
            </p>
            <p>
                …Oh yeah, and in a few days, when the algorithm is complete, you will see the 3-opt route of all the Canadian cities, so stay tuned and...
            </p>
            <p> GO CANADA!!!</p>
            <div class="cc" style="text-align:center">
                <a rel="license" href="http://creativecommons.org/licenses/by/2.0/">
                    <img alt="Creative Commons License" style="border-width:0" src="//i.creativecommons.org/l/by/3.0/88x31.png" /></a>
                    <br />This work is licensed under a <a rel="license" href="http://creativecommons.org/licenses/by/3.0/">Creative Commons Attribution 3.0 Generic License</a>.
            </div>
        </div>
        <script type="text/javascript" src="js/jquery.js"></script>
        <script type="text/javascript" src="js/jquery-ui.js"></script>
        <script type="text/javascript" src="js/datatables/jquery.dataTables.min.js"></script>
        <script type="text/javascript" src="js/cookies.js?<?php echo file_get_contents('api/version');?>"></script>
        <script type="text/javascript" src="js/workers.js?<?php echo file_get_contents('api/version');?>"></script>
        <script type="text/javascript" src="js/tsp.js?<?php echo file_get_contents('api/version');?>"></script>
        <script type="text/javascript" src="js/user.js?<?php echo file_get_contents('api/version');?>"></script>
        <script type="text/javascript" src="js/init.js?<?php echo file_get_contents('api/version');?>"></script>
    </body>
</html>
