<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
<meta charset="UTF-8">
<title>تفاصيل المنتج</title>

<style>
body{
    background:#041a17;
    color:white;
    font-family:sans-serif;
    text-align:center;
    padding:50px;
}

.box{
    background:#062622;
    padding:30px;
    border-radius:20px;
    border:1px solid #d4bc8e;
    max-width:600px;
    margin:auto;
}

h1{color:#d4bc8e;}

img{
    width:100%;
    border-radius:10px;
    margin-bottom:20px;
}

.section{
    text-align:right;
    margin-top:15px;
}

.section h3{
    color:#d4bc8e;
    margin-bottom:5px;
}

a{
    display:inline-block;
    margin-top:20px;
    padding:10px 20px;
    border:1px solid #d4bc8e;
    color:#d4bc8e;
    text-decoration:none;
    border-radius:5px;
}

a:hover{
    background:#d4bc8e;
    color:black;
}
</style>
</head>

<body>

<div class="box" id="productDetail">
<h2>جارٍ التحميل...</h2>
</div>

<script>
const products = [
{
id:1,
name:"إكسير الزمرد",
price:"$150",
img:"images/p1.jpg",
desc:"سيروم ليلي فاخر يعيد حيوية البشرة ويمنحها إشراقة طبيعية.",
ingredients:"مستخلص الزمرد - فيتامين C - حمض الهيالورونيك - زيوت طبيعية",
results:"ترطيب عميق - تقليل التجاعيد - بشرة مشرقة"
},
{
id:2,
name:"كريم الهيدra",
price:"$120",
img:"images/p2.jpg",
desc:"كريم ترطيب قوي يمنح البشرة نعومة تدوم طوال اليوم.",
ingredients:"ألوفيرا - جلسرين - زبدة الشيا",
results:"ترطيب 24 ساعة - نعومة فائقة"
},
{
id:3,
name:"منظف الذهب",
price:"$85",
img:"images/p3.jpg",
desc:"منظف عميق ينقي البشرة ويزيل الشوائب.",
ingredients:"ذهب نقي - كولاجين - مستخلص نباتي",
results:"تنظيف المسام - إشراقة ذهبية"
},
{
id:4,
name:"سيروم اللؤلؤ",
price:"$110",
img:"images/p4.jpg",
desc:"سيروم لتفتيح البشرة وإزالة البقع الداكنة.",
ingredients:"مسحوق اللؤلؤ - فيتامين E",
results:"تفتيح - توحيد لون البشرة"
},
{
id:5,
name:"كريم الليل",
price:"$95",
img:"images/p5.jpg",
desc:"كريم يعيد إصلاح البشرة أثناء النوم.",
ingredients:"زيوت طبيعية - كولاجين",
results:"تجديد الخلايا - بشرة صحية"
},
{
id:6,
name:"غسول البشرة",
price:"$70",
img:"images/p6.jpg",
desc:"غسول يومي لطيف للبشرة الحساسة.",
ingredients:"شاي أخضر - ألوفيرا",
results:"تنظيف لطيف - انتعاش"
},
{
id:7,
name:"ماسك الذهب",
price:"$130",
img:"images/p7.jpg",
desc:"ماسك فاخر يمنح البشرة إشراقة فورية.",
ingredients:"ذهب - فيتامين C",
results:"إشراقة فورية - شد البشرة"
},
{
id:8,
name:"زيت الجمال",
price:"$140",
img:"images/p8.jpg",
desc:"زيت طبيعي يغذي البشرة بعمق.",
ingredients:"زيت الورد - زيت اللوز",
results:"نعومة - تغذية"
},
{
id:9,
name:"كريم الشمس",
price:"$90",
img:"images/p9.jpg",
desc:"حماية قوية من أشعة الشمس الضارة.",
ingredients:"SPF طبيعي - زنك",
results:"حماية - منع التصبغات"
},
{
id:10,
name:"إكسير الشباب",
price:"$200",
img:"images/p10.jpg",
desc:"إكسير مضاد للتجاعيد واستعادة الشباب.",
ingredients:"كولاجين - فيتامين C - هيالورونيك",
results:"شد البشرة - تقليل التجاعيد"
}
];

const id = Number(new URLSearchParams(window.location.search).get("id"));

const item = products.find(p=>p.id===id);

const box = document.getElementById("productDetail");

if(item){
box.innerHTML = `
<img src="${item.img}" onerror="this.src='https://via.placeholder.com/300'">
<h1>${item.name}</h1>
<p>${item.desc}</p>
<h2 style="color:#d4bc8e">${item.price}</h2>

<div class="section">
<h3>✨ الوصف</h3>
<p>${item.desc}</p>
</div>

<div class="section">
<h3>🧪 المكونات</h3>
<p>${item.ingredients}</p>
</div>

<div class="section">
<h3>🌿 النتائج المتوقعة</h3>
<p>${item.results}</p>
</div>

<a href="index.html">← الرجوع للمنتجات</a>
`;
}else{
box.innerHTML = `
<h1>المنتج غير موجود</h1>
<a href="index.html">← الرجوع</a>
`;
}
</script>

</body>
</html>
