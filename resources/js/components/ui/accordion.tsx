import * as React from "react"
import { ChevronDown } from "lucide-react"

import { cn } from "@/lib/utils"
import {
  Collapsible,
  CollapsibleContent,
  CollapsibleTrigger,
} from "@/components/ui/collapsible"

type AccordionProps = {
  title: React.ReactNode
  open: boolean
  onOpenChange: (open: boolean) => void
  children: React.ReactNode
  rightSlot?: React.ReactNode
  className?: string
  triggerClassName?: string
  titleClassName?: string
  contentClassName?: string
  iconClassName?: string
}

function Accordion({
  title,
  open,
  onOpenChange,
  children,
  rightSlot,
  className,
  triggerClassName,
  titleClassName,
  contentClassName,
  iconClassName,
}: AccordionProps) {
  return (
    <Collapsible open={open} onOpenChange={onOpenChange} className={className}>
      <CollapsibleTrigger asChild>
        <button type="button" className={triggerClassName}>
          <span className={titleClassName}>{title}</span>
          <span className="flex items-center gap-2">
            {rightSlot}
            <ChevronDown
              className={cn("h-4 w-4 transition", open && "rotate-180", iconClassName)}
            />
          </span>
        </button>
      </CollapsibleTrigger>

      <CollapsibleContent className={contentClassName}>{children}</CollapsibleContent>
    </Collapsible>
  )
}

export { Accordion }
