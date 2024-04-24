// import Image from "next/image";
import styles from "./page.module.scss";

async function getPage(slug: string) {
  const res = await fetch('http://localhost:8888/wp-json/wp/v2/pages/' + slug + '?_embed')

  if (!res.ok) {
    throw new Error('Failed to fetch data')
  }
 
  return res.json()
}

export default async function Page({ params }: { params: { slug: string } }) {
  const data = await getPage( params.slug )

  return (
    <main className={styles.main}>
      <h1 className={styles.h1}>{data.title.rendered}</h1>
      {data._embedded?.['author']?.[0]?.name && (
        <p className={styles.author}>Author: {data._embedded?.['author']?.[0]?.name}</p>
      )}
      <div className={styles.content} dangerouslySetInnerHTML={{ __html: data.content.rendered }} />
    </main>
  );
}
