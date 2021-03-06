<?php

namespace EdsiTech\SirTrevorBundle\Handler;

use EdsiTech\SirTrevorBundle\Model\EditedBlock;
use Symfony\Component\HttpFoundation\Request;

class BlockHandler
{
    /**
     * Returns an array of Blocks from Request, from Edit:base form
     *
     * @param Request $request
     * @return array
     */
    public function handle(Request $request)
    {
        $newData = $this->readFromRequest($request);

        // Like this is easier than with JMS!
        $unserializedBlocks = [];
        for ($i = 0; $i < count($newData); $i++) {
            $unserializedBlocks[] = $this->unserializeBlock($newData[$i], $i);
        }

        return $unserializedBlocks;
    }

    /**
     * @param Request $request
     * @return array
     */
    protected function readFromRequest(Request $request)
    {
        $data = json_decode($request->request->get('blocks', '{}'), true);

        if (! isset($data['data'])) {
            return [];
        }

        return $data['data'];
    }

    /**
     * @param array $data
     * @param int $position
     * @return EditedBlock
     */
    protected function unserializeBlock(array $data, $position)
    {
        $block = new EditedBlock();

        $block->id          = isset($data['data']['id']) ? $data['data']['id'] : null;
        $block->type        = $data['type'];
        $block->position    = $position;
        $block->textContent = $data['data']['text'];

        return $block;
    }
}