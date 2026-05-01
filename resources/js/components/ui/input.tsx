import * as React from "react"

import { cn } from "@/lib/utils"

function Input({ className, type, ...props }: React.ComponentProps<"input">) {
  return (
    <input
      type={type}
      data-slot="input"
      className={cn(
        "poppins-regular w-full rounded-xl border border-[#e5e7eb] bg-white px-6 py-3 text-sm placeholder:text-[#9ca3af] outline-none transition-all",
        "focus-visible:border-[#3b82f6] focus-visible:ring-1 focus-visible:ring-[#3b82f6]",
        "disabled:bg-[#f3f4f6] disabled:cursor-not-allowed disabled:opacity-50",
        "aria-invalid:border-[#ef4444]",
        className
      )}
      {...props}
    />
  )
}

export { Input }
