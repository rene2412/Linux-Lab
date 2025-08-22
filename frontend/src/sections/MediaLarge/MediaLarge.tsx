import SectionFade from "../../components/ui/SectionFade";

export default function MediaLarge() {
  return (
    <section className="relative h-[750px] overflow-clip">
      <SectionFade variant="top" />
      <SectionFade variant="bottom" />
      <div className="-z-10 h-full w-full">
        <img
          src="media/asciibh.png"
          className="h-full w-full object-cover"
        ></img>
      </div>
    </section>
  );
}
