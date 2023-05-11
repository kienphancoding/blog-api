## Design Database cơ bản

<img alt="Design Database" src="./database.png"/>

Table blogs{
int id
title varchar
content array
author varchar
image varchar
path varchar
created_at timestamp
updated_at timestamp
}

Table blogCategories{
int id
blog_id int
category_id int
created_at timestamp
updated_at timestamp
}

Table categories{
int id
name varchar
path varchar
created_at timestamp
updated_at timestamp
}

Ref: "blogCategories"."blog_id" < "blogs"."int"

Ref: "blogCategories"."category_id" < "categories"."int"

## Route và API

# Blog (/blogs)

-   `GET "/"` : tham số count (số lượng blog) & page (thứ tự trang)
-   `GET "/{path}"` : lấy blog theo path
-   `GET "/category/{category}"` : lấy blog theo category
-   `POST , DELETE , PUT` : như bình thường ( JSON mẫu ở dưới)
-   {
    "title": "Mancity vô địch C1",
    "text": "['Hanni cute']",
    "author": "Kien Phan",
    "image": "asdfasfasdfsdfsafsadfsadfasdfsadfsdfsd adasa",
    "path": "mancity-vo-dich-c1",
    "category": [1,3,5,6]
    }

# Category (/categories)

-   `GET , GET(id) , POST , DELETE , PUT` : như bình thường (JSON mẫu ở dưới)

-   {"name": "Thể thao","path": "the-thao"}
