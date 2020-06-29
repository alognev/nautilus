#--------- Остальные задания -----------

#mysql
SELECT c.name, 
IF (c.email LIKE '%@mail.ru', 0, count(o.id)) as count

FROM clients c
left join orders o on c.id = o.clients_id and DATE_FORMAT(FROM_UNIXTIME(o.ctime), '%Y-%m') = '2015-03'
left join products p on o.id = p.order_id and p.`count` > 0

where p.id IN (151515,151617,151514)
group by c.name
order by SUM(p.price) desc

#javascript
<script>

var objects = [{count: 2, price: 21}, {count: 3, price: 10}];

function getSum(total, currentValue, currentIndex, arr) {
console.log(currentValue)
    return total + (parseFloat(currentValue.price) * parseInt(currentValue.count));
}

function onHidePage(){
	alert(objects.reduce(getSum, 0));
}

alert(objects.reduce(getSum, 0));

</script>

#https://git-scm.com/docs/git-stash
#Так то в master вообще нечего разоаботку вести :)
git stash
git checkout -b develop
git stash pop
git add
git commit -m 'change'
git push
git checkout master
git merge develop
git push