import { useEffect, useRef, useState } from "react";

// --- Custom Cursor ---
export const CustomCursor = () => {
  const cursorRef = useRef(null);
  const dotRef = useRef(null);

  useEffect(() => {
    // Only run on non-touch devices
    if (window.matchMedia("(pointer: coarse)").matches) return;

    const moveCursor = (e) => {
      if (dotRef.current) {
        dotRef.current.style.left = e.clientX + "px";
        dotRef.current.style.top = e.clientY + "px";
      }
      if (cursorRef.current) {
        // Little delay for the ring
        setTimeout(() => {
          if (cursorRef.current) {
            cursorRef.current.style.left = e.clientX + "px";
            cursorRef.current.style.top = e.clientY + "px";
          }
        }, 50);
      }

      const target = e.target;
      // Expand cursor on interactive elements
      if (target.closest("a, button, input, .hamburger, .nav-btn-link")) {
        cursorRef.current?.classList.add("active");
      } else {
        cursorRef.current?.classList.remove("active");
      }
    };

    document.addEventListener("mousemove", moveCursor);
    return () => document.removeEventListener("mousemove", moveCursor);
  }, []);

  return (
    <>
      <div className="cursor" ref={cursorRef}></div>
      <div className="cursor-dot" ref={dotRef}></div>
    </>
  );
};

// --- Monster Eye Tracking ---
export const useEyeTracking = (svgRef) => {
  useEffect(() => {
    const handleMove = (e) => {
      if (!svgRef.current) return;
      const eyes = svgRef.current.querySelectorAll(
        ".eyes circle:nth-child(even)"
      );
      const xAxis = (window.innerWidth / 2 - e.pageX) / 25;
      const yAxis = (window.innerHeight / 2 - e.pageY) / 25;
      eyes.forEach((eye) => {
        eye.style.transform = `translate(${Math.max(
          -15,
          Math.min(15, -xAxis)
        )}px, ${Math.max(-15, Math.min(15, -yAxis))}px)`;
      });
    };
    document.addEventListener("mousemove", handleMove);
    return () => document.removeEventListener("mousemove", handleMove);
  }, [svgRef]);
};

// --- 3D Tilt Effect ---
export const useTilt3D = () => {
  useEffect(() => {
    if (window.matchMedia("(max-width: 992px)").matches) return; // Disable on mobile

    const handleMove = (e) => {
      document.querySelectorAll(".tilt-card").forEach((card) => {
        const rect = card.getBoundingClientRect();
        const x = e.clientX - rect.left;
        const y = e.clientY - rect.top;
        // Only tilt if mouse is near/over the card
        if (x > -50 && x < rect.width + 50 && y > -50 && y < rect.height + 50) {
          const rotateX = ((y - rect.height / 2) / (rect.height / 2)) * -10;
          const rotateY = ((x - rect.width / 2) / (rect.width / 2)) * 10;
          card.style.transform = `perspective(1000px) rotateX(${rotateX}deg) rotateY(${rotateY}deg) scale(1.02)`;
        } else {
          card.style.transform = `perspective(1000px) rotateX(0) rotateY(0) scale(1)`;
        }
      });
    };
    document.addEventListener("mousemove", handleMove);
    return () => document.removeEventListener("mousemove", handleMove);
  }, []);
};

// --- Fade In On Scroll Component ---
export const FadeInSection = ({ children }) => {
  const [isVisible, setVisible] = useState(false);
  const domRef = useRef();

  useEffect(() => {
    const observer = new IntersectionObserver((entries) => {
      entries.forEach((entry) => {
        // When element enters viewport, set visible
        if (entry.isIntersecting) {
          setVisible(true);
        }
      });
    });
    const currentRef = domRef.current;
    if (currentRef) observer.observe(currentRef);
    return () => {
      if (currentRef) observer.unobserve(currentRef);
    };
  }, []);

  return (
    <div
      className={`fade-in-section ${isVisible ? "is-visible" : ""}`}
      ref={domRef}
    >
      {children}
    </div>
  );
};
