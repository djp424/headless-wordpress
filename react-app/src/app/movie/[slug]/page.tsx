// import Image from "next/image";
import styles from "./page.module.scss";

async function getMovie(slug: string) {
  const res = await fetch('http://localhost:8888/wp-json/wp/v2/movies/' + slug + '?_embed')

  if (!res.ok) {
    throw new Error('Failed to fetch data')
  }
 
  return res.json()
}

export default async function Page({ params }: { params: { slug: string } }) {
  const data = await getMovie( params.slug )

  return (
    <main className={styles.main}>
      <h1 className={styles.h1}>{data.title.rendered}</h1>
      {data._embedded?.['wp:term']?.[0]?.[0]?.name && (
        <p className={styles.author}>Genre: {data._embedded?.['wp:term']?.[0]?.[0]?.name}</p>
      )}
      {data._embedded?.['wp:featuredmedia']?.[0]?.source_url && (
        <img
          className={styles.featuredImage}
          src={data._embedded['wp:featuredmedia'][0].source_url}
          alt={data.title.rendered}
        />
      )}
      <div className={styles.content} dangerouslySetInnerHTML={{ __html: data.content.rendered }} />
    </main>
  );
}
