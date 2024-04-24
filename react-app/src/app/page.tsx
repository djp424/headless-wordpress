import styles from "./page.module.scss";
import Link from 'next/link';

async function getData() {
  const res = await fetch('http://localhost:8888/wp-json/wp/v2/movies?_embed&per_page=5')

  if (!res.ok) {
    throw new Error('Failed to fetch data')
  }
 
  return res.json()
}

export default async function Home() {
  const data = await getData()

  return (
    <main className={styles.main}>
      <h1>Select a Movie</h1>
      <div className={styles.movieContainer}>
        {data.map((movie: any) => (
          <Link href={`/movie/${movie.id}`}>
            <div key={movie.id} className={styles.movie}>
              <h2>{movie.title.rendered}</h2>
              {movie._embedded?.['wp:featuredmedia']?.[0]?.source_url && (
                <img
                  src={movie._embedded['wp:featuredmedia'][0].source_url}
                  alt={movie.title.rendered}
                  className={styles.image}
                />
              )}
              <div dangerouslySetInnerHTML={{ __html: movie.excerpt.rendered }} className={styles.excerpt} />
            </div>
          </Link>
        ))}
      </div>
    </main>
  );
}
