import { ChevronLeftIcon, ChevronRightIcon, SearchIcon } from "lucide-react"
import * as React from "react"

import { Button } from "@/components/ui/button"
import { Input } from "@/components/ui/input"
import { cn } from "@/lib/utils"

// ---------------------------------------------------------------------------
// Types
// ---------------------------------------------------------------------------

export interface ColumnDef<TData> {
    /** Key path into each row object, e.g. "name" or "address.city" */
    accessorKey: string
    /** Column header label */
    header: string
    /** Optional custom cell renderer */
    render?: (value: unknown, row: TData) => React.ReactNode
}

type PaginationMode = "client" | "server"
type FilterMode = "client" | "server"

export interface DataTableProps<TData> {
    /** Extra class names applied to the outermost wrapper */
    className?: string

    /** Column definitions */
    columns: ColumnDef<TData>[]

    /** Row data */
    data: TData[]

    // ── Filtering ────────────────────────────────────────────────────────────

    /**
     * When provided the filter input becomes a controlled element and filtering
     * is expected to be handled externally (server-side).
     * Omit to enable built-in client-side filtering.
     */
    filterValue?: string
    onFilterChange?: (value: string) => void
    filterPlaceholder?: string

    // ── Pagination ───────────────────────────────────────────────────────────

    /**
     * Number of rows per page.
     * - Client-side: defaults to 10; handled internally.
     * - Server-side: pass together with `onPageChange` / `totalCount`.
     */
    pageSize?: number

    /**
     * When provided together with `onPageChange` the component switches to
     * server-side pagination mode and these become controlled.
     */
    currentPage?: number
    totalCount?: number
    onPageChange?: (page: number) => void
    onPageSizeChange?: (size: number) => void

    /** Show a loading skeleton overlay while fetching */
    isLoading?: boolean

    /** Hide the filter input */
    hideFilter?: boolean

    /** Hide pagination controls */
    hidePagination?: boolean
}

// ---------------------------------------------------------------------------
// Helpers
// ---------------------------------------------------------------------------

/** Safely access a nested key like "address.city" on an object */
function getNestedValue(obj: Record<string, unknown>, path: string): unknown {
    return path.split(".").reduce<unknown>((acc, key) => {
        if (acc != null && typeof acc === "object") {
            return (acc as Record<string, unknown>)[key]
        }
        return undefined
    }, obj)
}

function matchesFilter(row: Record<string, unknown>, search: string): boolean {
    if (!search) return true
    const lower = search.toLowerCase()
    return Object.values(row).some((val) =>
        String(val ?? "").toLowerCase().includes(lower)
    )
}

const PAGE_SIZES = [10, 25, 50, 100]

// ---------------------------------------------------------------------------
// Component
// ---------------------------------------------------------------------------

function DataTable<TData extends Record<string, unknown>>({
    className,
    columns,
    data,
    // filter
    filterValue: controlledFilter,
    onFilterChange,
    filterPlaceholder = "Caută...",
    // pagination
    pageSize: pageSizeProp,
    currentPage: controlledPage,
    totalCount,
    onPageChange,
    onPageSizeChange,
    isLoading = false,
    hideFilter = false,
    hidePagination = false,
}: DataTableProps<TData>) {
    // ── Detect modes ─────────────────────────────────────────────────────────

    const filterMode: FilterMode =
        onFilterChange !== undefined ? "server" : "client"

    const paginationMode: PaginationMode =
        onPageChange !== undefined ? "server" : "client"

    // ── Internal state (client-side only) ────────────────────────────────────

    const [internalFilter, setInternalFilter] = React.useState("")
    const [internalPage, setInternalPage] = React.useState(1)
    const [internalPageSize, setInternalPageSize] = React.useState(
        pageSizeProp ?? 10
    )

    // Sync controlled pageSize prop into internal state when changed externally
    React.useEffect(() => {
        if (pageSizeProp !== undefined) setInternalPageSize(pageSizeProp)
    }, [pageSizeProp])

    // Derived values
    const filterSearch =
        filterMode === "server" ? (controlledFilter ?? "") : internalFilter

    const currentPage =
        paginationMode === "server" ? (controlledPage ?? 1) : internalPage

    const pageSize =
        paginationMode === "server"
            ? (pageSizeProp ?? internalPageSize)
            : internalPageSize

    // ── Data pipeline ─────────────────────────────────────────────────────────

    const filteredData = React.useMemo(() => {
        if (filterMode === "server") return data
        return data.filter((row) => matchesFilter(row, internalFilter))
    }, [data, filterMode, internalFilter])

    const total =
        paginationMode === "server"
            ? (totalCount ?? data.length)
            : filteredData.length

    const totalPages = Math.max(1, Math.ceil(total / pageSize))

    const pagedData = React.useMemo(() => {
        if (paginationMode === "server") return filteredData
        const start = (internalPage - 1) * internalPageSize
        return filteredData.slice(start, start + internalPageSize)
    }, [filteredData, paginationMode, internalPage, internalPageSize])

    // ── Handlers ─────────────────────────────────────────────────────────────

    function handleFilterChange(value: string) {
        if (filterMode === "server") {
            onFilterChange?.(value)
        } else {
            setInternalFilter(value)
            setInternalPage(1) // reset to first page on filter change
        }
    }

    function handlePageChange(page: number) {
        const clamped = Math.max(1, Math.min(page, totalPages))
        if (paginationMode === "server") {
            onPageChange?.(clamped)
        } else {
            setInternalPage(clamped)
        }
    }

    function handlePageSizeChange(size: number) {
        if (paginationMode === "server") {
            onPageSizeChange?.(size)
        } else {
            setInternalPageSize(size)
            setInternalPage(1)
        }
    }

    // ── Render ───────────────────────────────────────────────────────────────

    return (
        <div className={cn("poppins-regular flex flex-col gap-3", className)}>
            {/* Filter bar */}
            {!hideFilter && (
                <div className="flex items-center gap-2">
                    <div className="relative flex-1 max-w-xs">
                        <SearchIcon className="absolute left-3 top-1/2 -translate-y-1/2 size-4 text-[#9ca3af] pointer-events-none" />
                        <Input
                            type="search"
                            placeholder={filterPlaceholder}
                            value={filterSearch}
                            onChange={(e) => handleFilterChange(e.target.value)}
                            className="pl-9"
                        />
                    </div>
                </div>
            )}

            {/* Table wrapper */}
            <div className="relative w-full overflow-x-auto rounded-sm">
                {isLoading && (
                    <div className="absolute inset-0 z-10 bg-white/60 flex items-center justify-center">
                        <span className="text-sm text-[#6b7280]">Se încarcă...</span>
                    </div>
                )}

                <table className="w-full border-collapse text-sm text-[#111827]">
                    <thead>
                        <tr>
                            {columns.map((col) => (
                                <th
                                    key={col.accessorKey}
                                    className="border border-[#9ca3af] bg-white px-4 py-2 text-center font-normal text-[#111827] whitespace-nowrap"
                                >
                                    {col.header}
                                </th>
                            ))}
                        </tr>
                    </thead>
                    <tbody>
                        {pagedData.length === 0 ? (
                            <tr>
                                <td
                                    colSpan={columns.length}
                                    className="border border-[#9ca3af] bg-white h-12 px-4 text-center text-[#9ca3af]"
                                >
                                    Nu există date.
                                </td>
                            </tr>
                        ) : (
                            pagedData.map((row, rowIdx) => (
                                <tr key={rowIdx} className="group">
                                    {columns.map((col) => {
                                        const rawValue = getNestedValue(row, col.accessorKey)
                                        return (
                                            <td
                                                key={col.accessorKey}
                                                className="border border-[#9ca3af] bg-white h-12 px-4 py-2 text-left align-middle group-hover:bg-gray-50 transition-colors"
                                            >
                                                {col.render
                                                    ? col.render(rawValue, row)
                                                    : String(rawValue ?? "")}
                                            </td>
                                        )
                                    })}
                                </tr>
                            ))
                        )}
                    </tbody>
                </table>
            </div>

            {/* Pagination bar */}
            {!hidePagination && (
                <div className="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between text-sm text-[#6b7280]">
                    {/* Left: rows info + page size selector */}
                    <div className="flex items-center gap-3">
                        <span className="whitespace-nowrap">
                            {total === 0
                                ? "0 înregistrări"
                                : `${(currentPage - 1) * pageSize + 1}–${Math.min(
                                      currentPage * pageSize,
                                      total
                                  )} din ${total}`}
                        </span>

                        <div className="flex items-center gap-1.5">
                            <span className="whitespace-nowrap">Rânduri pe pagină</span>
                            <select
                                value={pageSize}
                                onChange={(e) =>
                                    handlePageSizeChange(Number(e.target.value))
                                }
                                className="rounded border border-[#e5e7eb] bg-white px-2 py-1 text-sm text-[#111827] outline-none focus:border-[#3b82f6] cursor-pointer"
                            >
                                {PAGE_SIZES.map((s) => (
                                    <option key={s} value={s}>
                                        {s}
                                    </option>
                                ))}
                            </select>
                        </div>
                    </div>

                    {/* Right: page navigation */}
                    <div className="flex items-center gap-1">
                        <Button
                            variant="outline"
                            size="icon"
                            className="size-8"
                            disabled={currentPage <= 1}
                            onClick={() => handlePageChange(1)}
                            aria-label="Prima pagină"
                        >
                            <ChevronLeftIcon className="size-4" />
                            <ChevronLeftIcon className="-ml-2.5 size-4" />
                        </Button>
                        <Button
                            variant="outline"
                            size="icon"
                            className="size-8"
                            disabled={currentPage <= 1}
                            onClick={() => handlePageChange(currentPage - 1)}
                            aria-label="Pagina anterioară"
                        >
                            <ChevronLeftIcon className="size-4" />
                        </Button>

                        {/* Page number pills */}
                        <PageNumbers
                            currentPage={currentPage}
                            totalPages={totalPages}
                            onPageChange={handlePageChange}
                        />

                        <Button
                            variant="outline"
                            size="icon"
                            className="size-8"
                            disabled={currentPage >= totalPages}
                            onClick={() => handlePageChange(currentPage + 1)}
                            aria-label="Pagina următoare"
                        >
                            <ChevronRightIcon className="size-4" />
                        </Button>
                        <Button
                            variant="outline"
                            size="icon"
                            className="size-8"
                            disabled={currentPage >= totalPages}
                            onClick={() => handlePageChange(totalPages)}
                            aria-label="Ultima pagină"
                        >
                            <ChevronRightIcon className="size-4" />
                            <ChevronRightIcon className="-ml-2.5 size-4" />
                        </Button>
                    </div>
                </div>
            )}
        </div>
    )
}

// ---------------------------------------------------------------------------
// Page number pills (renders up to 5 page buttons around current page)
// ---------------------------------------------------------------------------

function PageNumbers({
    currentPage,
    totalPages,
    onPageChange,
}: {
    currentPage: number
    totalPages: number
    onPageChange: (page: number) => void
}) {
    const pages = React.useMemo(() => {
        const delta = 2
        const range: number[] = []
        for (
            let i = Math.max(1, currentPage - delta);
            i <= Math.min(totalPages, currentPage + delta);
            i++
        ) {
            range.push(i)
        }
        return range
    }, [currentPage, totalPages])

    if (totalPages <= 1) return null

    return (
        <div className="flex items-center gap-1">
            {pages[0] > 1 && (
                <>
                    <PagePill page={1} active={false} onClick={onPageChange} />
                    {pages[0] > 2 && (
                        <span className="px-1 text-[#9ca3af]">…</span>
                    )}
                </>
            )}
            {pages.map((p) => (
                <PagePill
                    key={p}
                    page={p}
                    active={p === currentPage}
                    onClick={onPageChange}
                />
            ))}
            {pages[pages.length - 1] < totalPages && (
                <>
                    {pages[pages.length - 1] < totalPages - 1 && (
                        <span className="px-1 text-[#9ca3af]">…</span>
                    )}
                    <PagePill page={totalPages} active={false} onClick={onPageChange} />
                </>
            )}
        </div>
    )
}

function PagePill({
    page,
    active,
    onClick,
}: {
    page: number
    active: boolean
    onClick: (page: number) => void
}) {
    return (
        <button
            type="button"
            onClick={() => onClick(page)}
            className={cn(
                "inline-flex size-8 items-center justify-center rounded border text-sm transition-colors",
                active
                    ? "border-[#111827] bg-[#111827] text-white"
                    : "border-[#e5e7eb] bg-white text-[#111827] hover:bg-gray-50"
            )}
        >
            {page}
        </button>
    )
}

export { DataTable }
